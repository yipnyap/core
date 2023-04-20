import React, {Fragment, useEffect, useState} from 'react';
import {NGButton, NGHeading} from '@nextgen2/components';
import {Dialog, Transition} from '@headlessui/react';
import {XMarkIcon} from '@heroicons/react/24/outline';

import styles from './import.module.css';
import {Checkbox, FormControl, FormHelperText} from "@mui/joy";

function classNames(...classes: string[]) {
    return classes.filter(Boolean).join(' ')
}

function MediaSlideover({...props}: any) {
    const [open, setOpen] = props.open;
    const [file] = props.file;
    const [files, setFiles] = props.files;

    return (
        <Transition.Root show={open} as={Fragment}>
            <Dialog as="div" className="fixed inset-0 overflow-hidden z-50" onClose={setOpen}>
                <div className="absolute inset-0 overflow-hidden">
                    <Transition.Child
                        as={Fragment}
                        enter="transition-opacity ease-linear duration-100"
                        enterFrom="opacity-0"
                        enterTo="opacity-100"
                        leave="transition-opacity ease-linear duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                    >
                        <Dialog.Overlay
                            className="fixed inset-0 bg-neutral-500/25 bg-opacity-75 backdrop-blur transition-opacity"/>
                    </Transition.Child>
                    <div className="pointer-events-none fixed inset-y-0 right-0 flex max-w-screen-md pl-10">
                        <Transition.Child
                            as={Fragment}
                            enter="transition ease-out duration-150 sm:ease-snapper sm:duration-300"
                            enterFrom="transform opacity-0 scale-110 sm:translate-x-full sm:scale-100 sm:opacity-100"
                            enterTo="transform opacity-100 scale-100  sm:translate-x-0 sm:scale-100 sm:opacity-100"
                            leave="transition ease-in duration-150 sm:ease-snapper sm:duration-300"
                            leaveFrom="transform opacity-100 scale-100 sm:translate-x-0 sm:scale-100 sm:opacity-100"
                            leaveTo="transform opacity-0 scale-110  sm:translate-x-full sm:scale-100 sm:opacity-100"
                        >
                            <div className="pointer-events-auto relative">
                                <Transition.Child
                                    as={Fragment}
                                    enter="ease-in-out duration-500"
                                    enterFrom="opacity-0"
                                    enterTo="opacity-100"
                                    leave="ease-in-out duration-500"
                                    leaveFrom="opacity-100"
                                    leaveTo="opacity-0"
                                >
                                    <div className="absolute top-0 left-0 -ml-8 flex pt-4 pr-2 sm:-ml-10 sm:pr-4">
                                        <button
                                            type="button"
                                            className="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                            onClick={() => setOpen(false)}
                                        >
                                            <span className="sr-only">Close panel</span>
                                            <XMarkIcon className="h-6 w-6" aria-hidden="true" />
                                        </button>
                                    </div>
                                </Transition.Child>
                                <div className="h-full overflow-y-auto bg-box-solid p-8">
                                    <div className="space-y-6 pb-16">
                                        <div>
                                            <div className="aspect-w-10 aspect-h-7 block w-full overflow-hidden rounded-default">
                                                <img
                                                    src={file?.image}
                                                    alt=""
                                                    className="object-cover"
                                                />
                                            </div>
                                            <div className="mt-4 flex items-start justify-between">
                                                <div>
                                                    <h2 className="text-lg font-medium text-default">
                                                        <span className="sr-only">Details for </span>{file?.title}
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 className="font-medium text-default">Information</h3>
                                            <dl className="mt-2 divide-y divide-gray-200 border-t border-b border-gray-200">
                                                <div className="flex justify-between py-3 text-sm font-medium">
                                                    <dt className="text-default-alt">FurAffinity ID</dt>
                                                    <dd className="text-default">{file?.id}</dd>
                                                </div>

                                                <div className="flex justify-between py-3 text-sm font-medium">
                                                    <dt className="text-default-alt">Estimated Upload Date</dt>
                                                    <dd className="text-default">{new Date(file?.date).toLocaleDateString()}</dd>
                                                </div>

                                                <div className="flex justify-between py-3 text-sm font-medium">
                                                    <dt className="text-default-alt">Rating</dt>
                                                    <dd className="text-default">{file?.rating}</dd>
                                                </div>

                                                <div className="flex justify-between py-3 text-sm font-medium">
                                                    <dt className="text-default-alt">Is Scrapped</dt>
                                                    <dd className="text-default">{file?.scrap ? 'Yes' : 'No'}</dd>
                                                </div>

                                                <div className="flex justify-between py-3 text-sm font-medium">
                                                    <dt className="text-default-alt">Tags</dt>
                                                    <dd className="text-default">{file?.tags.join(', ')}</dd>
                                                </div>
                                            </dl>
                                        </div>
                                        <div>
                                            <h3 className="font-medium text-default">Description</h3>
                                            <div className="mt-2 flex items-center justify-between">
                                                <p className="text-sm italic text-neutral-400 whitespace-pre-wrap">
                                                    {file?.description}
                                                </p>
                                            </div>
                                        </div>
                                        <div className="flex">
                                            <NGButton
                                                variant="primary"
                                                className="flex-1"
                                            >
                                                Save
                                            </NGButton>
                                            <NGButton
                                                variant="danger"
                                                className="ml-3 flex-1"
                                                onClick={() => {
                                                    setOpen(false);

                                                    setTimeout(() => {
                                                        // Set file's `isDeleting` to true
                                                        setFiles(files.map((f: { id: any; isDeleting: boolean; }) => {
                                                            if (f.id === file?.id) {
                                                                f.isDeleting = true;
                                                            }
                                                            return f;
                                                        }));

                                                        setTimeout(() => {
                                                            // Remove the file from the list
                                                            setFiles(files.filter((f: { id: any; }) => f.id !== file?.id));
                                                        }, 1000)
                                                    }, 1000)
                                                }}
                                            >
                                                Delete
                                            </NGButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Transition.Child>
                    </div>
                </div>
            </Dialog>
        </Transition.Root>
    )
}

function MediaSlideoverMultiSelect({...props}: any) {
    const { files, states } = props;
    const [open, setOpen] = props.open;
    const [faxpFiles, setFaxpFiles] = states;

    return (
        <Transition.Root show={open} as={Fragment}>
            <Dialog as="div" className="fixed inset-0 overflow-hidden z-50" onClose={setOpen}>
                <div className="absolute inset-0 overflow-hidden">
                    <Transition.Child
                        as={Fragment}
                        enter="transition-opacity ease-linear duration-100"
                        enterFrom="opacity-0"
                        enterTo="opacity-100"
                        leave="transition-opacity ease-linear duration-100"
                        leaveFrom="opacity-100"
                        leaveTo="opacity-0"
                    >
                        <Dialog.Overlay
                            className="fixed inset-0 bg-neutral-500/25 bg-opacity-75 backdrop-blur transition-opacity"/>
                    </Transition.Child>
                    <div className="pointer-events-none fixed inset-y-0 right-0 flex max-w-screen-md pl-10">
                        <Transition.Child
                            as={Fragment}
                            enter="transition ease-out duration-150 sm:ease-snapper sm:duration-300"
                            enterFrom="transform opacity-0 scale-110 sm:translate-x-full sm:scale-100 sm:opacity-100"
                            enterTo="transform opacity-100 scale-100  sm:translate-x-0 sm:scale-100 sm:opacity-100"
                            leave="transition ease-in duration-150 sm:ease-snapper sm:duration-300"
                            leaveFrom="transform opacity-100 scale-100 sm:translate-x-0 sm:scale-100 sm:opacity-100"
                            leaveTo="transform opacity-0 scale-110  sm:translate-x-full sm:scale-100 sm:opacity-100"
                        >
                            <div className="pointer-events-auto relative">
                                <Transition.Child
                                    as={Fragment}
                                    enter="ease-in-out duration-500"
                                    enterFrom="opacity-0"
                                    enterTo="opacity-100"
                                    leave="ease-in-out duration-500"
                                    leaveFrom="opacity-100"
                                    leaveTo="opacity-0"
                                >
                                    <div className="absolute top-0 left-0 -ml-8 flex pt-4 pr-2 sm:-ml-10 sm:pr-4">
                                        <button
                                            type="button"
                                            className="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                            onClick={() => setOpen(false)}
                                        >
                                            <span className="sr-only">Close panel</span>
                                            <XMarkIcon className="h-6 w-6" aria-hidden="true" />
                                        </button>
                                    </div>
                                </Transition.Child>
                                <div className="h-full overflow-y-auto bg-box-solid p-8">
                                    <div className="space-y-6 p-16">
                                        <div>
                                            {/* Collage of images from `files` array (`.image`) */}
                                            <div className="relative w-full">
                                                <div className="absolute inset-0 flex flex-col">
                                                    <div
                                                        className="border border-solid border-default rounded-default shadow-md opacity-50 flex-1 w-full h-full transition-transform -rotate-3 hover:-rotate-2">
                                                        <img src={files[files.length - 1]?.image} alt="" className="w-full h-full rounded-default object-cover" />
                                                    </div>
                                                </div>
                                                <div className="absolute inset-0 flex flex-col">
                                                    <div
                                                        className="border border-solid border-default rounded-default shadow-lg opacity-75 flex-1 w-full h-full transition-transform rotate-6 hover:rotate-[5deg] dark:bg-sidebar-dark">
                                                        <img src={files[1]?.image} alt="" className="w-full h-full rounded-default object-cover" />
                                                    </div>
                                                </div>

                                                <div
                                                    className="relative bg-default border border-solid border-default rounded-default shadow-xl transition-transform rotate-2 hover:rotate-1">
                                                    <img src={files[0].image} alt="" className="w-full h-full rounded-default object-cover" />
                                                </div>
                                            </div>

                                            <div className="mt-4 flex items-start justify-between">
                                                <div>
                                                    <h2 className="text-lg font-medium text-default">
                                                        <span className="sr-only">Details for </span>{files.length} selected files
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="flex">
                                            <NGButton
                                                className="flex-1"
                                            >
                                                Close
                                            </NGButton>
                                            <NGButton
                                                variant="danger"
                                                className="ml-3 flex-1"
                                                onClick={() => {
                                                    setOpen(false);

                                                    setTimeout(() => {
                                                        // Set isDeleting to all files in `files` array
                                                        setFaxpFiles(faxpFiles.map((file: any) => {
                                                            if (files.includes(file)) {
                                                                file.isDeleting = true;
                                                            }
                                                            return file;
                                                        }));

                                                        // Remove all files from `files` array
                                                        setTimeout(() => {
                                                            // Remove the selected files from the list
                                                            setFaxpFiles(faxpFiles.filter((file: any) => !files.includes(file)));
                                                        }, 1000)
                                                    }, 1000);
                                                }}
                                            >
                                                Delete
                                            </NGButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Transition.Child>
                    </div>
                </div>
            </Dialog>
        </Transition.Root>
    )
}

export default function SettingsImport() {
    const [faxpInput, setFAXPInput] = useState<HTMLInputElement | null>(null);
    const [faxpValidated, setFAXPValidated] = useState<boolean | null>(null); // null = not validated, true = validated, false = invalid
    const [faxpIsValidating, setFAXPIsValidating] = useState<boolean>(false);
    const [faxpPhotos, setFAXPPhotos] = useState<any[]>([]); // TODO: type this properly
    const [faxpIsMature, setFAXPIsMature] = useState<boolean>(false);

    const [doFilesizeCheck, setDoFilesizeCheck] = useState<boolean>(true);

    // Files per second
    const [fps, setFPS] = useState<number>(0);

    const [selectedPhoto, setSelectedPhoto] = useState<any>(null);
    const [openMultiDrawer, setOpenMultiDrawer] = useState<boolean>(false);
    const [openDrawer, setOpenDrawer] = useState<boolean>(false);

    const handleFAXPUpload = async (e: React.FormEvent<HTMLInputElement>) => {
        setFAXPIsValidating(true);
        setFAXPValidated(null);

        setTimeout(() => {
            setFAXPInput(e.currentTarget);
        }, 1000);

        const files = e.currentTarget?.files;
        // make sure that it's not null or undefined
        if (files) {
            // Set the contents of the file to the state `faxpPhotos`
            const file = files[0];
            const reader = new FileReader();

            reader.onload = (e) => {
                const contents = e.target?.result;
                if (contents) {
                    const json = JSON.parse(contents.toString());

                    let lastFileTime = 0;
                    let i = 0;
                    for (const photo of json) {
                        if (!doFilesizeCheck) {
                            setTimeout(() => {
                                photo.size = '?';
                                photo.width = '?';
                                photo.height = '?';

                                setFAXPPhotos((prev) => [photo, ...prev]);

                                // Calculate the files per second
                                const now = Date.now();
                                const timeDiff = now - lastFileTime;
                                const filesPerSecond = 1000 / timeDiff;
                                lastFileTime = now;
                                setFPS(Math.round(filesPerSecond));

                                i++;
                                if (i === json.length) {
                                    setFAXPIsValidating(false);
                                    setFAXPValidated(true);
                                }
                            }, 10 * i);
                        } else {
                            // Get the image file size and resolution from the image URL
                            getImageData(photo.image).then((data) => {
                                // Convert bytes to either KB or MB
                                photo.size = data.size > 1000000 ? `${(data.size / 1000000).toFixed(2)} MB` : `${(data.size / 1000).toFixed(2)} KB`;
                                photo.width = data.width;
                                photo.height = data.height;

                                // Add the photo to the state
                                setFAXPPhotos((prev) => [photo, ...prev]);

                                // Calculate the files per second
                                const now = Date.now();
                                const timeDiff = now - lastFileTime;
                                const filesPerSecond = 1000 / timeDiff;
                                lastFileTime = now;
                                setFPS(Math.round(filesPerSecond));

                                i++;
                                if (i === json.length) {
                                    setFAXPIsValidating(false);
                                    setFAXPValidated(true);
                                }
                            });
                        }
                    }

                    // Check if any file's `rating` is *not* `General` or `Unknown`
                    const isMature = json.some((file: any) => file.rating !== 'General' && file.rating !== 'Unknown');
                    setFAXPIsMature(isMature);
                }
            }

            try {
                reader.readAsText(file);
            } catch (e) {
                alert('Sorry, but importing could not continue. Please reload and try again.')
            }
        }
    };

    // Get the image file size and resolution from the image URL
    const getImageData = async (url: string): Promise<{
        size: number,
        width: number,
        height: number,
    }> => {
        return new Promise(async (resolve, reject) => {
            const img = new Image();
            img.src = url;

            img.onload = async () => {
                const fileSizeFetch = await fetch(`https://faxp.rekkisomo.workers.dev/faxp/${url.replace('https://d.furaffinity.net/art/', '')}`, {
                    method: 'HEAD',
                });

                const fileSize = fileSizeFetch.headers.get('Content-Length');

                resolve({
                    size: fileSize ? parseInt(fileSize) : 0,
                    width: img.width,
                    height: img.height,
                });
            };
            img.onerror = reject;
        })
    }

    useEffect(() => {
        // Filter through photos and check if any are selected, if so, set the selected photo to an array of the selected photos
        const selectedPhotos = faxpPhotos.filter((photo: any) => photo.selected);
        if (selectedPhotos.length > 0) {
            // Reverse it uwu
            setSelectedPhoto(selectedPhotos.reverse());
        } else {
            setSelectedPhoto(null);
        }

        // If there are any mature photos, set faxpIsMature to true
        setFAXPIsMature(faxpPhotos.some((photo: any) => photo.rating !== 'General' && photo.rating !== 'Unknown'));
    }, [faxpPhotos]);

    return (
       <>
           <div className="flex flex-col space-y-8">
               <div className="flex flex-col space-y-4">
                   <NGHeading>Import to Yipnyap</NGHeading>
                   <div className="space-y-2">
                       <p className="text-sm text-default-alt">
                           You can import all your submissions from a supported service,
                           like FurAffinity, to Yipnyap. You will need to be logged in to
                           the service you are importing from within this browser.
                       </p>
                       <p className="text-sm text-tertiary">
                           Yipnyap is not affiliated with any of these services. We are not
                           responsible for any data loss, account prosecutions, or
                           other issues that may arise from using this service.
                       </p>
                   </div>
               </div>

               <div className="flex flex-col space-y-4">
                   <NGHeading>FurAffinity Importing</NGHeading>
                   <p className="text-sm text-amber-500">
                       You need to download an open-source tool to export
                       your .faxp file. We can't do this here due to how
                       web browsers work. If you would like to see what
                       we'll get, you can open the .faxp file in any text
                       editor.
                   </p>
                   <p className="text-sm text-default-alt">
                       <strong>All files will be uploaded in 1 post!</strong>{' '}
                       You can edit the post to say what you want after the
                       import is complete!
                   </p>

                   {/* File upload field */}
                   <div className="flex flex-col space-y-2">
                       <label htmlFor="fa-faxp" className="text-sm text-default-alt">
                           Upload your .faxp file
                       </label>
                       {/* Modern style */}
                       <div className="relative">
                           <input
                               type="file"
                               id="fa-faxp"
                               name="fa-faxp"
                               className="sr-only"
                               accept=".faxp"
                               onInput={handleFAXPUpload}
                           />
                           <div
                               className={`group relative w-full h-12 cursor-pointer bg-box ${faxpValidated ? 'highlight-emerald-500/25' : faxpIsValidating ? 'highlight-amber-500/25' : 'highlight-white/5'} rounded-md flex justify-between items-center px-4 sm:text-sm`}
                               onClick={() => document.getElementById('fa-faxp')?.click()}
                           >
                            <span className="text-neutral-500">
                                {(faxpInput && faxpInput.files) && faxpInput.files.length > 0 ? faxpInput.files[0].name : 'No file selected'}
                            </span>
                               <span className="text-neutral-500 group-hover:text-neutral-900 dark:group-hover:text-neutral-600">
                                Change
                            </span>
                           </div>
                       </div>

                       <FormControl>
                           <Checkbox checked={doFilesizeCheck} onChange={() => setDoFilesizeCheck(!doFilesizeCheck)} label="Get File Metadata" />
                           <FormHelperText>
                               Gets filesize and resolution. Disabling might improve initial pre-check performance, but
                               will hang your browser for a while if you have a lot of files compared to leaving
                               this enabled.
                           </FormHelperText>
                       </FormControl>
                   </div>

                   {faxpIsValidating && (
                       <div className="flex flex-col space-y-2">
                           <NGHeading>
                               This may take a while, please wait... ({fps} per second)
                           </NGHeading>
                           <p className="text-sm text-default-alt">
                               If your browser becomes unresponsive, wait about 5 minutes. If it's still unresponsive,
                               kill the tab and try again.
                           </p>
                       </div>
                   )}

                     {faxpValidated && faxpPhotos.length > 0 && (
                         <div className="flex flex-col space-y-2">
                             {faxpIsMature && (
                                 <p className="text-sm text-amber-500">
                                     <strong>Warning:</strong> Some of the files you are importing are marked as mature.{' '}
                                     Your post will be marked as such.
                                 </p>
                             )}

                             <NGButton
                                 className="w-full"
                                 onClick={() => console.log(faxpPhotos)}
                             >
                                 Import
                             </NGButton>
                             <p className="text-sm text-default-alt">
                                 By clicking "Import", you agree that you have the rights to all the files you are
                                 importing, and that you have manually verified that all content abides to Yipnyap's
                                 Community Guidelines.
                             </p>
                         </div>
                     )}

                   {/* Grid with photo and title */}
                   {((doFilesizeCheck && !faxpValidated) || faxpValidated) && faxpPhotos.length > 0 && (
                       <>
                           <NGHeading>{faxpPhotos.length} to be imported</NGHeading>
                           <ul
                               role="list"
                               className="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
                           >
                               {faxpPhotos.map((file) => (
                                   <li key={file.id} className={`relative ${file.isDeleting ? styles.animDelete : ''}`}>
                                       <div
                                           className={classNames(
                                               file.current
                                                   ? 'ring-2 ring-offset-2 ring-indigo-500'
                                                   : 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500',
                                               'group block w-full aspect-w-10 aspect-h-7 rounded-default bg-box overflow-hidden'
                                           )}
                                           onClick={() => {
                                               // If `selectedPhoto` is an array, set `openMultiDrawer` to true
                                               if (Array.isArray(selectedPhoto)) {
                                                   setOpenMultiDrawer(true);
                                               } else {
                                                   setSelectedPhoto(file)
                                                   setOpenDrawer(true);
                                               }
                                           }}
                                       >
                                           <img
                                               src={file.image}
                                               alt=""
                                               className={classNames(
                                                   file.current ? '' : 'group-hover:opacity-75',
                                                   'object-cover pointer-events-none'
                                               )}
                                           />
                                           <button type="button" className="absolute inset-0 focus:outline-none">
                                               <span className="sr-only">View details for {file.title}</span>
                                           </button>
                                       </div>
                                       <p className={`flex flex-row mt-2 text-sm font-medium ${file.rating !== 'General' && file.rating !== 'Unknown' ? 'text-tertiary' : 'text-default'} truncate`}>
                                           {/* Select checkbox */}
                                           <Checkbox className="inline-block w-4 h-4 mr-2"
                                                     checked={file.selected}
                                                     onChange={() => {
                                                         const newPhotos = [...faxpPhotos];
                                                         const index = newPhotos.findIndex((p) => p.id === file.id);
                                                         newPhotos[index].selected = !newPhotos[index].selected;
                                                         setFAXPPhotos(newPhotos);
                                                     }} />

                                           {file.title}
                                       </p>
                                       <p className="block text-sm font-medium text-default-alt pointer-events-none">
                                           {file.size}, {file.width}x{file.height}
                                       </p>
                                   </li>
                               ))}
                           </ul>
                       </>
                   )}
               </div>
           </div>

           {(selectedPhoto) && selectedPhoto.length > 0 ? (
               <MediaSlideoverMultiSelect files={selectedPhoto} states={[faxpPhotos, setFAXPPhotos]} open={[openMultiDrawer, setOpenMultiDrawer]} />
           ) : (
               <MediaSlideover file={[selectedPhoto, setSelectedPhoto]} files={[faxpPhotos, setFAXPPhotos]} open={[openDrawer, setOpenDrawer]} />
           )}
       </>
    );
}
