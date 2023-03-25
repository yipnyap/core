<?php
/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace Yipnyap;

require_once YIPNYAP_PATH . '/includes/functions/nextgen/AllocatedStorage/index.php';

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use WP_Error;
use WP_Http;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * /storage/ endpoint
 *
 * @package Yipnyap
 * @since ui2
 */
class AllocatedStorage_Rest_Endpoint extends WP_REST_Controller {
    /**
     * Constructor.
     *
     * @since ui2
     */
    public function __construct() {
        $this->namespace = 'v2';
        $this->rest_base = '/storage';
    }

    /**
     * Registers the routes for the objects of the controller.
     *
     * @since ui2
     *
     * @see register_rest_route()
     */
    public function register(): void {
        register_rest_route($this->namespace, $this->rest_base, [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_items'],
                'permission_callback' => [$this, 'get_items_permissions_check'],
                'args' => $this->get_collection_params(),
            ],
            'schema' => [$this, 'get_public_item_schema'],
        ]);
    }

    /**
     * Checks if a given request has access to read items.
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return true|WP_Error True if the request has read access, WP_Error object otherwise.
     *
     * @since ui2
     */
    public function get_items_permissions_check($request): true|WP_Error {
        // User needs to be logged in
        if (!is_user_logged_in()) {
            return new WP_Error('rest_forbidden', __('You are not allowed to view the storage information.', 'yipnyap'), ['status' => WP_Http::UNAUTHORIZED]);
        }

        return true;
    }

    /**
     * Retrieves a collection of items.
     *
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     *
     * @since ui2
     *
     * @see YipnyapGetStorageUsage()
     */
    public function get_items($request): WP_Error|WP_REST_Response {
        $usageBytes = YipnyapGetStorageUsage(get_current_user_id());

        // Get all files in user dir & user meta dir
        $user_dir = YIPNYAP_UPLOADS_PATH . '/member/' . get_current_user_id();
        $user_meta_dir = wp_get_upload_dir()['basedir'] . '/members/' . get_current_user_id();
        $files = [];

        // Combine all files into one array
        foreach ([$user_dir, $user_meta_dir] as $dir) {
            $files = array_merge($files, iterator_to_array(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS))));
        }

        $data = [
            'usage' => [
                'bytes' => $usageBytes,
                'human' => YipnyapFSHumanReadable($usageBytes),
            ],
            'max' => [
                // 5GB as bytes
                'bytes' => 5000000000,
                'human' => YipnyapFSHumanReadable(5000000000),
            ],
        ];

        // Pagination
        $page = (int) $request->get_param('page');
        $perPage = (int) $request->get_param('per_page');
        $total = count($files);
        $pages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;
        $files = array_slice($files, $offset, $perPage);

        // Format data into array
        foreach ($files as $file) {
            $build = [
                'name' => $file->getFilename(),
                'size' => [
                    'bytes' => $file->getSize(),
                    'human' => YipnyapFSHumanReadable(round($file->getSize())),
                ],
            ];

            $path = str_replace('\\', '/', str_replace(wp_get_upload_dir()['basedir'], '', $file->getPathname()));
            $dontIncludePath = false;

            // If name includes 'bpthumb' then it's a thumbnail
            if (str_contains($build['name'], 'bpthumb')) {
                $build['name'] = 'Avatar Thumbnail';
                $dontIncludePath = true;
            } elseif (str_contains($build['name'], 'yp-cover-image')) {
                $build['name'] = 'Cover Image';
                $dontIncludePath = true;
            } elseif (str_contains($build['name'], 'bpfull')) {
                $build['name'] = 'Avatar Full Resolution';
                $dontIncludePath = true;
            }

            if (str_contains($path, 'history')) {
                $build['name'] .= ' - Archived';
            } elseif (!$dontIncludePath) {
                $build['path'] = $path;
            }

            $data['files'][] = $build;
        }

        // Sort by size
        usort($data['files'], fn($a, $b) => $b['size']['bytes'] <=> $a['size']['bytes']);

        $response = rest_ensure_response($data);
        $response->header('X-NG2-Total', $total);
        $response->header('X-NG2-Total-Pages', $pages);
        $response->header('X-NG2-Per-Page', $perPage);
        $response->header('X-NG2-Current-Page', $page);

        return $response;
    }

}