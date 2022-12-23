import React, {Fragment, useEffect, useState} from "react";
import {Dialog, Transition} from "@headlessui/react";
import {useLocation} from "react-router-dom";
import {ExclamationTriangleIcon, ExclamationCircleIcon} from "@heroicons/react/24/solid";

const creatorNotices = [
    {
        title: 'How to add a new page & chapter',
        body: <>
            To add a new page or chapter, simply upload the asset(s) as a regular post. The
            chapter number will be automatically detected and the page(s) will be added to the
            chapter.
            <br /><br />
            The asset name must be in the format of <code>arcana-chap#-page#</code> where <code>chap#</code> is
            the chapter number and <code>page#</code> is the page number.
            <br /><br />
            For example, the asset's file name, for page 2 of chapter 1 (which is a jpg in this
            example) would be <code>arcana-1-2.jpg</code>.
        </>
    },
    {
        title: 'Replacing a page',
        body: <>
            To replace a page, go to <a href={`/${yipnyap_constants.currentUser.username}/photos`}>your photos</a>,
            then find and delete the old asset. simply upload the new asset as you were adding a new page, with
            the same name as the old asset. It will be inserted in the same place as the old asset.
        </>
    }
]
export default function Arcana({...props}: any) {
    const location = useLocation();
    let [isOpen, setIsOpen] = useState(false);
    let [openChapterID, setOpenChapterID] = useState<number | false>(false);
    const [posts, setPosts] = useState<{
        title: string;
        href: string;
        ongoing: boolean;
        description: string;
        pages: string[];
    }[]>([]);

    useEffect(() => {
        console.log(isOpen);
        if (!isOpen) {
            history.pushState("", document.title, window.location.pathname + window.location.search);
        }
    }, [isOpen]);

    useEffect( () => {
        // Get comic data
        fetch('/api/v2/comic/arcana').then(async (res) => {
            const json = await res.json();
            // Sort through json, find all unique chapters
            const chapters = json
                .filter((item: any) => item.chapter !== null)
                .map((item: any) => item.chapter)
                .filter((item: any, index: number, self: any) => self.indexOf(item) === index);
            // Create posts array
            const postsNew = chapters.map((chapter: any) => {
                const pages = json.filter((item: any) => item.chapter === chapter);
                return {
                    title: `Chapter ${chapter}`,
                    href: `#chapter-${chapter}`,
                    ongoing: chapters.length === parseInt(chapter),
                    description: `${pages.length} pages`,
                    pages: pages.map((item: any) => {
                        return item.image;
                    }),
                };
            });
            setPosts(postsNew);

            if (location.hash && location.hash.startsWith('#chapter-')) {
                const chapterID = location.hash.replace('#chapter-', '');
                if (chapters.indexOf(chapterID) > -1) {
                    setOpenChapterID(parseInt(chapterID));
                    setIsOpen(true);
                }
            }
        })

        if (!location.hash || !location.hash.startsWith('#chapter-')) {
            setIsOpen(false);
        }
    }, [location.pathname, location.hash]);

    function openChapter() {
        setIsOpen(true)
    }

    // Landing page for the Arcana Comic
    return (
        <>
            <Transition appear show={isOpen} as={Fragment}>
                <Dialog as="div" className="relative z-10" onClose={() => setIsOpen(false)}>
                    <Transition.Child
                        as={Fragment}
                        enter="ease-out duration-300"
                        enterFrom="opacity-0"
                        enterTo="opacity-100"
                        leave="ease-in duration-200"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                    >
                        <div className="fixed inset-0 bg-black bg-opacity-25" />
                    </Transition.Child>

                    <div className="fixed inset-0 overflow-y-auto">
                        <div className="flex min-h-full items-center justify-center my-20 text-center">
                            <Transition.Child
                                as={Fragment}
                                enter="ease-out duration-300"
                                enterFrom="opacity-0 scale-95"
                                enterTo="opacity-100 scale-100"
                                leave="ease-in duration-200"
                                leaveFrom="opacity-100 scale-100"
                                leaveTo="opacity-0 scale-95"
                            >
                                <Dialog.Panel className="w-full max-w-4xl transform overflow-hidden rounded-2xl bg-box align-middle shadow-xl transition-all">
                                    {/* Loop through post pages */}
                                    {openChapterID && posts[openChapterID - 1]?.pages.map((page, index) => (
                                        <img key={index} src={page} />
                                    ))}

                                </Dialog.Panel>
                            </Transition.Child>
                        </div>
                    </div>
                </Dialog>
            </Transition>

            {/* Header with background image and text over it on the bottom */}
            <div className="relative w-full">
                <img
                    className="h-96 w-full object-cover"
                    src="https://voidhound.carrd.co/assets/images/image01.jpg?v=ced037e9"
                    alt=""
                />
                <div className="absolute left-0 bottom-0 w-full bg-box">
                    {/* Bottom card with text and avatar on left */}
                    <div className="flex bg-box p-8 flex-col w-full">
                        <div className="text-3xl font-bold leading-none text-default">
                            Arcana
                        </div>
                        <div className="text-xl font-medium leading-none text-alt">
                            By Voidhound_
                        </div>
                    </div>
                </div>
            </div>

            {/* List of chapters and summary */}
            <div className="flex flex-col w-full h-full p-8 bg-box">
                {/* How-to card if user is voidhound_ */}
                {props.isGabe && (
                    <>
                        <div className="flex items-center text-2xl font-bold leading-none text-default mb-12">
                            <ExclamationCircleIcon className="h-6 w-6 mr-2" /> Creator Notices
                        </div>
                        <div className="max-w-lg grid gap-5 lg:grid-cols-3 lg:max-w-none mb-12">
                            {creatorNotices.map((notice, index) => (
                                <div key={index} className="flex flex-col bg-box p-8 mb-8 max-w-lg rounded-xl">
                                    {/* "Only you can see this" */}
                                    <div className="flex flex-row items-center mb-4">
                                        <ExclamationTriangleIcon className="h-6 w-6 text-yellow-500" />
                                        <div className="ml-2 font-medium leading-none text-default">
                                            Only you can see this
                                        </div>
                                    </div>
                                    <div className="text-xl font-bold leading-none text-default mb-4">
                                        {notice.title}
                                    </div>
                                    <div className="font-medium leading-none text-alt-2">
                                        {notice.body}
                                    </div>
                                </div>
                            ))}
                        </div>
                    </>
                )}
                <div className="text-2xl font-bold leading-none text-default mb-12">
                    Chapters
                </div>
                {/* List of chapters */}
                <div className="max-w-lg grid gap-5 lg:grid-cols-3 lg:max-w-none">
                    {posts.map((post) => (
                        <div key={post.title} className="flex flex-col rounded-lg shadow-lg overflow-hidden">
                            <div className="flex-1 bg-box p-6 flex flex-col justify-between">
                                <div className="flex-1">
                                    <p className="text-sm font-medium text-indigo-600">
                                        {post.ongoing ? 'Ongoing' : 'Completed'}
                                    </p>
                                    <a href={post.href} className="block mt-2" onClick={openChapter}>
                                        <p className="text-xl font-semibold text-default">{post.title}</p>
                                        <p className="mt-3 text-base text-alt">{post.description}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </>
    )
}