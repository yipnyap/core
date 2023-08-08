<?php
namespace Yipnyap;

class UserRelationship {
    public array $RelationshipStatus;
    public string $InitiatorID;
    public string $TargetID;

    /**
     * Configure relationship initiator and target.
     */
    public function SetRelationshipInfo($initiator, $target = 0): void {
        $this->InitiatorID = $initiator;
        $this->TargetID = $target;
    }

    /**
     * Create follow
     */
    public function CreateFollow(): bool {
        return bp_follow_start_following([
            'leader_id' => $this->TargetID,
            'follower_id' => $this->InitiatorID,
        ]);
    }

    /**
     * Remove follow
     */
    public function RemoveFollow(): bool {
        return bp_follow_stop_following([
            'leader_id' => $this->TargetID,
            'follower_id' => $this->InitiatorID,
        ]);
    }

    /**
     * Check if users are mutuals (following each other)
     */
    public function IsMutual(): bool {
        $Target = bp_follow_is_following([
            'leader_id' => $this->TargetID,
            'follower_id' => $this->InitiatorID,
        ]);
        $Initiator = bp_follow_is_following([
            'leader_id' => $this->InitiatorID,
            'follower_id' => $this->TargetID,
        ]);

        return $Target && $Initiator;
    }

    /**
     * Create a friend request
     */
    public function CreateFriendRequest(): bool {
        $relationship = $this->GetRelationshipInfo(true);
        if ($relationship['status'] !== '') {
            return false;
        } else {
            return friends_add_friend($this->InitiatorID, $this->TargetID);
        }
    }

    public function RemoveFriend(): bool {
        return friends_remove_friend($this->InitiatorID, $this->TargetID);
    }

    /**
     * Get relationship status.
     */
    public function GetRelationshipInfo($skipFollowCheck = false): array {
        $this->RelationshipStatus = [];
        if ($this->IsFollowing() && !$skipFollowCheck) {
            $this->RelationshipStatus[] = 'following';
        }

        $friendRequests = $this->GetFriendRequests();
        $friendRequestsReceived = $this->GetReceivedFriendRequests();
        if (in_array($this->InitiatorID, $friendRequests)) {
            $this->RelationshipStatus[] = 'pending';
        } elseif (in_array($this->TargetID, $friendRequests)) {
            $this->RelationshipStatus[] = 'awaiting_response';
        } elseif (in_array($this->InitiatorID, $friendRequestsReceived)) {
            $this->RelationshipStatus[] = 'awaiting_response';
        } elseif (in_array($this->TargetID, $friendRequestsReceived)) {
            $this->RelationshipStatus[] = 'pending';
        } elseif ($this->IsFriend()) {
            $this->RelationshipStatus[] = 'is_friend';
        }

        return [
            'initiator' => $this->InitiatorID,
            'target' => $this->TargetID,
            'status' => join('|', $this->RelationshipStatus),
        ];
    }

    /**
     * Check if user is following another user
     */
    public function IsFollowing(): bool {
        return bp_follow_is_following([
            'leader_id' => $this->TargetID,
            'follower_id' => $this->InitiatorID,
        ]);
    }

    /**
     * Get friend requests
     */
    public function GetFriendRequests(): array {
        $requests = [];
        $friend_requests = yipnyap_get_friend_requests_sent($this->InitiatorID);
        foreach ($friend_requests as $request) {
            $requests[] = [
                'id' => $request->id,
            ];
        }

        return $requests;
    }

    /**
     * Get received friend requests
     *
     * @return array
     * @since hk16-hf2
     */
    public function GetReceivedFriendRequests(): array {
        $requests = [];
        $friend_requests = yipnyap_get_friend_requests_received($this->InitiatorID);
        foreach ($friend_requests as $request) {
            $requests[] = [
                'id' => $request->id,
            ];
        }

        return $requests;
    }

    /**
     * Check if users are friends
     *
     * @return bool
     * @since hk15
     */
    public function IsFriend(): bool {
        $friends = $this->GetFriends();
        return in_array($this->TargetID, $friends);
    }

    /**
     * Get all friends
     *
     * @return array
     * @since hk16-hf2
     */
    public function GetFriends(): array {
        $friend_args = [
            'per_page' => 0,
            'page' => 0,
            'filter' => '',
        ];

        // $friend_args = array_replace($friend_args, $args);

        $friends = friends_get_alphabetically($this->InitiatorID, $friend_args['per_page'], $friend_args['page'], $friend_args['filter']);
        $f = [];

        foreach ($friends['users'] as $friend) {
            $f[] = $friend->ID;
        }

        return $f;
    }
}
