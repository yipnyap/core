import {NGBody, NGCard, NGHeading} from '@nextgen2/components';
import React from 'react';
import {FaceSmileIcon, QueueListIcon} from "@heroicons/react/20/solid";

export default function Terms() {
    return (
        <NGBody>
            <div className="max-w-3xl mx-auto">
                <div className="flex flex-col space-y-8">
                    <div className="flex flex-col space-y-4">
                        <div className="space-y-1">
                            <NGHeading>
                                Yipnyap Terms of Service
                            </NGHeading>
                            <span className="font-bold text-sm text-default-alt">
                            blah blah
                        </span>
                        </div>
                        <p className="text-default-alt">
                            cum
                        </p>
                    </div>

                    {/* Preface */}
                    <NGCard
                        title="Preface"
                    >
                        Welcome to Yipnyap, where we strive to create a safe and positive environment for all users. By
                        using our site, you agree to abide by the following terms and conditions as laid out on this
                        page. If you do not agree to these terms, please do not use our site.
                    </NGCard>

                    {/* Definitions */}
                    <NGCard
                        title="Definitions"
                        wellBody
                    >
                        <ul className="list-disc list-inside space-y-2">
                            <li>
                                <span className="font-bold">Yipnyap</span> - The site you are currently using.
                            </li>
                            <li>
                                <span className="font-bold">User</span> - A person who accesses Yipnyap.
                            </li>
                            <li>
                                <span className="font-bold">Content</span> - Any text, image, or other media that a user
                                posts on Yipnyap.
                            </li>
                            <li>
                                <span className="font-bold">Moderator</span> - A person who moderates Yipnyap. They have
                                power over every aspect of the site, including the ability to ban users and delete
                                content at will.
                            </li>
                            <li>
                                <span className="font-bold">Administrator</span> - A person who administrates Yipnyap.
                                Similar to Moderator, however they control the entire site, and are responsible for
                                all decisions made by the site and its Moderators.
                            </li>
                            <li>
                                <span className="font-bold">Yipnyap Foundation</span> - The entire team behind Yipnyap,
                                including administrators, moderators, programmers, public relations, et cetra.
                            </li>
                        </ul>
                    </NGCard>

                    {/* User Responsibilities */}
                    <NGCard
                        title="User Responsibilities"
                        wellBody
                    >
                        <ul className="list-none space-y-2">
                            <li>
                                <FaceSmileIcon className="w-5 h-5 inline-block mr-1"/>
                                <span className="font-bold">Be respectful</span> - This is a site for everyone. Do not
                                harass, threaten, or otherwise cause harm to other users. Do not post content that
                                is sexually explicit, violent, or otherwise inappropriate for a general audience. You
                                are expected to be respectful of other users, and to treat them as you would like to
                                be treated. Do not be racist, sexist, or otherwise discriminatory, and do not condone
                                such behavior.
                            </li>
                            <li>
                                <QueueListIcon className="w-5 h-5 inline-block mr-1"/>
                                <span className="font-bold">Do not spam</span> - Do not post the same content
                                multiple times. Do not post content that is irrelevant to the current conversation.
                            </li>
                            <li>
                                <span className="font-bold">Do not impersonate</span> - Do not pretend to be someone
                                else. Do not post content that is not yours.
                            </li>
                            <li>
                                <span className="font-bold">Do not violate the law</span> - Do not post content that
                                violates any local or Australian laws. Do not post content that violates the rights
                                of others.
                            </li>
                        </ul>
                    </NGCard>

                    {/* Age Limits & Parent / Guardian Consenting */}
                    <NGCard
                        title="Age Limits & Parent / Guardian Consenting"
                        wellBody
                    >
                        Our site is only available to individuals who are 13 years of age or older. If you are under
                        the age of 13, you are not permitted to use our site. For users under the age of 16, we comply
                        with the EU's General Data Protection Regulation (GDPR) and require parental or guardian consent.
                    </NGCard>

                    {/* Account Registration & Accuracy */}
                    <NGCard
                        title="Account Registration & Accuracy"
                        wellBody
                    >
                        To use our site, you must register for an account. You agree to provide accurate and complete
                        information when registering, and to keep your account information up-to-date. You are
                        responsible for safeguarding your account credentials and for any activity that occurs under
                        your account.
                    </NGCard>

                    {/* Content Ownership */}
                    <NGCard
                        title="Content Ownership"
                        wellBody
                    >
                        You retain ownership of any content you post on our site. However, you grant us a non-exclusive,
                        royalty-free, worldwide, perpetual, irrevocable, and transferable license to use, reproduce,
                        distribute, prepare derivative works of, display, and perform your content in connection with
                        our site and our services. This license is for the sole purpose of operating, promoting,
                        and improving our site, and to develop new services. You understand that we may not pay you
                        for any of the rights granted under this license and that you are not entitled to any
                        compensation for any of the rights granted under this license.
                        <br /><br />
                        We agree to not use your content for any purpose other than as described in this license,
                        and to not transfer your content or any rights granted under this license to any third party
                        without your consent, except as required by law.
                        <br /><br />
                        If in the future you delete content you posted on our site, we may retain archived copies of
                        your content for a reasonable period of time. We may also retain cached or archived copies of
                        your content to provide a CDN service. Yipnyap is not responsible for any content that is
                        stored, cached, or archived by third parties, such as search engines, or other users of our
                        site.
                    </NGCard>

                    {/* Government Requests & Demands */}
                    <NGCard
                        title="Data Disclosure & Government Demands"
                        wellBody
                    >
                        <div className="flex flex-col space-y-6">
                            <div>
                                We may disclose your content or other information about you if we have a good faith belief
                                that such disclosure is reasonably necessary to:
                            </div>
                            <ul className="list-disc list-inside space-y-2">
                                <li>Comply with a legal process;</li>
                                <li>Enforce this agreement;</li>
                                <li>Respond to claims that any content violates the rights of third parties;</li>
                                <li>Respond to your requests for customer service;</li>
                                <li>Protect the rights, property, or personal safety of Yipnyap, its users, or the public.</li>
                            </ul>
                            <div>
                                We will attempt at not disclosing your content or other information about you to
                                government agencies unless we have a good faith belief that such disclosure is
                                reasonably necessary to comply with a legal process. We will not accept any form of
                                payment from government agencies in exchange for disclosing your content or other
                                information about you.
                            </div>
                            <div>
                                In the event that we are required to disclose your content or other information about
                                you to a government agency, we will attempt to notify you of such disclosure. We will
                                also publicly disclose the number of government requests we receive, and the number of
                                such requests that we comply with. We will also ask the government agency to provide
                                us with a copy of the request to publish on our site as required by this agreement.
                            </div>
                            <hr className="border border-solid border-default my-4"/>
                            <h3 className="text-xl font-bold">Government Requests in relation to Identity</h3>
                            <div>
                                We will not comply with the request if the request directly or indirectly relates to
                                the following if the government agency is within a state or country in which the following
                                is deemed illegal (such as but not limited to, the state of Florida within the United
                                States of America):
                            </div>
                            <ul className="list-disc list-inside space-y-2">
                                <li>User's sexual identity, gender, sexual orientation, or race;</li>
                                <li>User's involvement in online communities or groups, such as the LGBTQ+ community (or
                                    other names for such groups that is socially accepted), or the furry community (or
                                    "furry fandom" or "furries");</li>
                            </ul>
                            <div>
                                If the aformentioned government agency wishes to obtain information about a user, and
                                we have reason to believe that the request is in direct violation of this agreement,
                                and the government agency is wishing to attend a court hearing to obtain the information,
                                it must be agreed that the hearing shall be held in the state of Victoria, Australia,
                                and that the transcript of the hearing shall be published on our site. If the government
                                agency is unable to agree to these terms, we will not comply with the request unless
                                absolutely required by both the government agency and is within the laws of Australia.
                            </div>
                            <div>
                                In the event that we have no other choice but to comply with the request, and is directly
                                or indirectly in relation to the aformentioned topics, we will immediately cease all
                                operations of our site in the specific state or country in which the request was made,
                                and purge all data from our servers about users listed within the request. All users
                                affected will be notified of the termination of our site in their state or country, and
                                will be given the option to export their data from our site before the termination of
                                our site in their state or country. Yipnyap may choose to ressurect our site in the
                                future as long as it is deemed safe and secure to do so.
                            </div>
                        </div>
                    </NGCard>

                    {/* Termination of Access */}
                    <NGCard
                        title="Termination of Access"
                        wellBody
                    >
                        We reserve the right to terminate your access to our site at any time and for any reason,
                        including if you violate these terms of service. If we terminate your access, you may not
                        create a new account or use our site in any way.
                    </NGCard>

                    {/* COPPA Compliance */}
                    <NGCard
                        title="COPPA Compliance"
                        wellBody
                    >
                        Our site is not directed to children under the age of 13. If you are under the age of 13,
                        you may not use our site. If we learn that we have collected personal information from a
                        child under the age of 13, we will delete that information as quickly as possible. If you
                        believe we might have any information from or about a child under the age of 13, please
                        contact us at <a href="https://work.yipnyap.me/">any support contact</a>.
                    </NGCard>

                    {/* GDPR Compliance */}
                    <NGCard
                        title="GDPR Compliance"
                        wellBody
                    >
                        We are committed to complying with the General Data Protection Regulation (GDPR) and
                        other applicable data protection laws. We will only process your personal data in
                        accordance with our privacy policy and in compliance with the applicable data protection
                        laws. If you have any questions about our privacy policy or data processing, please
                        contact us at <a href="https://work.yipnyap.me/">any support contact</a>.
                    </NGCard>

                    {/* Warranty & Liability */}
                    <NGCard
                        title="Warranty & Liability"
                        wellBody
                    >
                        Our site is provided on an "as is" and "as available" basis, without any warranties of any kind,
                        express or implied. We do not guarantee that our site will be error-free, uninterrupted, or secure.
                        <br /><br />
                        We will not be liable for any damages, including but not limited to, direct, indirect,
                        incidental, consequential, or punitive damages arising from your use of our site.
                        <br /><br />
                        You agree to indemnify and hold us harmless from any claims, damages, and expenses (including
                        reasonable attorney's fees) arising from your use of our site, your violation of these terms of
                        service, or your violation of any third-party rights.
                    </NGCard>
                </div>
            </div>
        </NGBody>
    );
}