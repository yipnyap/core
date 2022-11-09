import React from 'react';
import {CrawlText} from "../../community-ui/snapper-engine/CrawlText";

export default function ActivityNotice(props) {
    return (
        <div className="flex flex-col sm:flex-row items-center lg:!pl-24 pb-12">
            <div
                className="flex-grow items-center"
            >
                <div className="mx-auto px-4">
                    <p
                        className="text-xl tracking-tight font-bold"
                        style={{
                            whiteSpace: 'break-spaces',
                        }}
                    >
                        <CrawlText>
                            Survey has now closed. Thanks to those who responded!
                        </CrawlText>
                    </p>
                    {/*<p*/}
                    {/*    className="mt-2 text-alt"*/}
                    {/*    style={{*/}
                    {/*        whiteSpace: 'break-spaces',*/}
                    {/*    }}*/}
                    {/*>*/}
                    {/*    <CrawlText delay={300 + 50 * 8} fast={true}>*/}
                    {/*        Thanks for using Yipnyap during the beta. We're reaching the end of it, and we'd*/}
                    {/*        like to know what you think! ::break: You'll get a badge if you fill out the survey!*/}
                    {/*    </CrawlText>*/}
                    {/*</p>*/}
                </div>
            </div>

            {/*<div*/}
            {/*    className="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start"*/}
            {/*>*/}
            {/*    <div className="rounded-lg shadow px-4 lg:px-8">*/}
            {/*        <a*/}
            {/*            href="https://forms.gle/L71fWaZByariaiWK9"*/}
            {/*            target="_blank"*/}
            {/*            className="ypsdk button-upgrade flex items-center justify-center !px-8 !py-3 !leading-6"*/}
            {/*            color="primary"*/}
            {/*        >*/}
            {/*            Start*/}
            {/*        </a>*/}
            {/*    </div>*/}
            {/*</div>*/}
        </div>
    );
}
