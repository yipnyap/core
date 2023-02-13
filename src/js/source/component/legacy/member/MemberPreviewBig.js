import React, {useRef, useEffect} from 'react';

import friendUtils from '../utils/friend';

import Avatar from '../avatar/Avatar';

import IconSVG from '../icon/IconSVG';

import BadgeItemList from '../badge/BadgeItemList';
import BadgeVerified from '../badge/BadgeVerified';

import SocialLinkList from '../social-link/SocialLinkList';
import SocialLink from '../social-link/SocialLink';

import AddFriendButton from '../button/action-button/action-button-friend/AddFriendButton';
import AcceptFriendRequestButton from '../button/action-button/action-button-friend/AcceptFriendRequestButton';
import WithdrawFriendRequestButton from '../button/action-button/action-button-friend/WithdrawFriendRequestButton';
import RemoveFriendButton from '../button/action-button/action-button-friend/RemoveFriendButton';

import ButtonLink from '../button/ButtonLink';

import {truncateText} from '../../../utils/core';
import {createSlider} from '../../../utils/plugins';

import {getURLIcon} from '../utils/xprofile';

function MemberPreviewBig(props) {
    const socialLinksSlidesPerView = 5;

    const socialLinks = [];

    if (props.data.profile_data.group.Social_Links) {
        for (const socialField of props.data.profile_data.group.Social_Links) {
            if (socialField.value !== '') {
                socialLinks.push({
                    name: getURLIcon(socialField.name),
                    link: socialField.value
                });
            }
        }
    }

    const statsSliderRef = useRef(null);
    const statsPaginationRef = useRef(null);

    let statsSlider = undefined;

    const bioAbout = props.data.profile_data.field.Profile_Bio_About ? props.data.profile_data.field.Profile_Bio_About.value : '';

    useEffect(() => {
        if (bioAbout !== '') {
            statsSlider = createSlider(statsSliderRef.current, {
                pagination: {
                    el: statsPaginationRef.current,
                    type: 'bullets',
                    clickable: true,
                    bulletClass: 'slider-roster-item',
                    bulletActiveClass: 'active',
                    renderBullet: function (index, className) {
                        return `<div class="${className}"></div>`;
                    }
                }
            });
        }

        return () => {
            if (statsSlider) {
                // Destroy slider instance and detach all events listeners
                statsSlider.destroy();
            }
        };
    }, []);

    const socialLinksSliderRef = useRef(null);
    const socialLinksControlPrevRef = useRef(null);
    const socialLinksControlNextRef = useRef(null);

    let socialLinksSlider = undefined;

    useEffect(() => {
        if (socialLinks.length > socialLinksSlidesPerView) {
            socialLinksSlider = createSlider(socialLinksSliderRef.current, {
                navigation: {
                    prevEl: socialLinksControlPrevRef.current,
                    nextEl: socialLinksControlNextRef.current
                },
                slidesPerView: socialLinksSlidesPerView,
                spaceBetween: 8
            });
        }

        return () => {
            if (socialLinksSlider) {
                // Destroy slider instance and detach all events listeners
                socialLinksSlider.destroy();
            }
        };
    }, []);

    const friendable = friendUtils(props.loggedUser, props.data.id);

    const postCountText = props.data.stats.post_count === 1 ? yipnyap_translation.post : yipnyap_translation.posts,
        friendCountText = props.data.stats.friend_count === 1 ? yipnyap_translation.friend : yipnyap_translation.friends,
        commentCountText = props.data.stats.comment_count === 1 ? yipnyap_translation.comment : yipnyap_translation.comments;

    const displayVerifiedMemberBadge = yipnyap_constants.plugin_active['bp-verified-member'] && yipnyap_constants.settings.bp_verified_member_display_badge_in_members_lists && props.data.verified;

    return (
        <div className="user-preview">
            {/* USER PREVIEW COVER */}
            <div className="user-preview-cover"
                 style={{background: `url(${props.data.cover_url}) center center / cover no-repeat`}}></div>
            {/* USER PREVIEW COVER */}

            <div className="user-preview-info">
                <div className="user-short-description">
                    <Avatar size="medium"
                            modifiers="user-short-description-avatar"
                            data={props.data}
                    />

                    <p className="user-short-description-title">
                        <a href={props.data.link}>{props.data.name}</a>
                        {
                            displayVerifiedMemberBadge && yipnyap_constants.settings.bp_verified_member_display_badge_in_profile_fullname &&
                            <BadgeVerified/>
                        }
                    </p>
                    <p className="user-short-description-text">
                        <a href={props.data.link}>&#64;{props.data.mention_name}</a>
                        {
                            displayVerifiedMemberBadge && yipnyap_constants.settings.bp_verified_member_display_badge_in_profile_username &&
                            <BadgeVerified/>
                        }
                    </p>
                </div>

                {
                    yipnyap_constants.gamipress_badge_type_exists &&
                    <React.Fragment>
                        {
                            (props.data.badges.length > 0) &&
                            <BadgeItemList data={props.data.badges} maxDisplayCount={4}
                                           moreLink={props.data.badges_link} modifiers="small"/>
                        }
                        {
                            (props.data.badges.length === 0) &&
                            <p className="no-results-text">{yipnyap_translation.no_badges_unlocked}</p>
                        }
                    </React.Fragment>
                }

                {/* USER PREVIEW STATS SLIDES */}
                {
                    bioAbout === '' &&
                    <div className="user-preview-stats-slides">
                        <div className="user-preview-stats-slide">
                            <div className="user-stats">
                                <div className="user-stat">
                                    <p className="user-stat-title">{props.data.stats.post_count}</p>
                                    <p className="user-stat-text">{postCountText}</p>
                                </div>
                                {
                                    yipnyap_constants.plugin_active.buddypress_friends &&
                                    <div className="user-stat">
                                        <p className="user-stat-title">{props.data.stats.friend_count}</p>
                                        <p className="user-stat-text">{friendCountText}</p>
                                    </div>
                                }
                                <div className="user-stat">
                                    <p className="user-stat-title">{props.data.stats.comment_count}</p>
                                    <p className="user-stat-text">{commentCountText}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                }
                {
                    bioAbout !== '' &&
                    <div ref={statsSliderRef} className="user-preview-stats-slides swiper-container">
                        <div className="user-preview-stats-slide swiper-wrapper">
                            <div className="user-stats swiper-slide">
                                <div className="user-stat">
                                    <p className="user-stat-title">{props.data.stats.post_count}</p>
                                    <p className="user-stat-text">{postCountText}</p>
                                </div>
                                {
                                    yipnyap_constants.plugin_active.buddypress_friends &&
                                    <div className="user-stat">
                                        <p className="user-stat-title">{props.data.stats.friend_count}</p>
                                        <p className="user-stat-text">{friendCountText}</p>
                                    </div>
                                }
                                <div className="user-stat">
                                    <p className="user-stat-title">{props.data.stats.comment_count}</p>
                                    <p className="user-stat-text">{commentCountText}</p>
                                </div>
                            </div>

                            <div className="user-preview-stats-slide swiper-slide">
                                <p className="user-preview-text">{truncateText(bioAbout, 120)}</p>
                            </div>
                        </div>
                    </div>
                }
                {/* USER PREVIEW STATS SLIDES */}

                {/* USER PREVIEW STATS ROSTER */}
                <div ref={statsPaginationRef} className="user-preview-stats-roster slider-roster">
                </div>
                {/* USER PREVIEW STATS ROSTER */}

                {/* SOCIAL LINKS */}
                {
                    (socialLinks.length > 0) && (socialLinks.length <= socialLinksSlidesPerView) &&
                    <SocialLinkList data={socialLinks}
                                    modifiers="small"
                    />
                }
                {
                    (socialLinks.length > socialLinksSlidesPerView) &&
                    <div className="user-preview-social-links-wrap">
                        {/* USER PREVIEW SOCIAL LINKS SLIDER */}
                        <div ref={socialLinksSliderRef} className="user-preview-social-links-slider swiper-container">
                            {/* USER PREVIEW SOCIAL LINKS */}
                            <div className="user-preview-social-links swiper-wrapper">
                                {
                                    socialLinks.map((socialItem, i) => {
                                        return (
                                            <div key={i} className="user-preview-social-link swiper-slide">
                                                <SocialLink data={socialItem}
                                                            modifiers="small"
                                                />
                                            </div>
                                        );
                                    })
                                }
                            </div>
                            {/* USER PREVIEW SOCIAL LINKS */}
                        </div>
                        {/* USER PREVIEW SOCIAL LINKS SLIDER */}

                        {/* SLIDER CONTROLS */}
                        <div className="slider-controls">
                            {/* SLIDER CONTROL */}
                            <div ref={socialLinksControlPrevRef} className="slider-control left">
                                <IconSVG icon="small-arrow"
                                         modifiers="slider-control-icon"
                                />
                            </div>
                            {/* SLIDER CONTROL */}

                            {/* SLIDER CONTROL */}
                            <div ref={socialLinksControlNextRef} className="slider-control right">
                                <IconSVG icon="small-arrow"
                                         modifiers="slider-control-icon"
                                />
                            </div>
                            {/* SLIDER CONTROL */}
                        </div>
                        {/* SLIDER CONTROLS */}
                    </div>
                }
                {/* SOCIAL LINKS */}

                {
                    (socialLinks.length === 0) &&
                    <p className="no-results-text no-results-social">{yipnyap_translation.no_social_networks_linked}</p>
                }

                {
                    yipnyap_constants.plugin_active.buddypress_friends &&
                    <div className="user-preview-actions">
                        {
                            props.loggedUser && (props.loggedUser.id !== props.data.id) &&
                            <React.Fragment>
                                {
                                    !friendable.isFriend() &&
                                    <React.Fragment>
                                        {
                                            !friendable.friendRequestSent() && !friendable.friendRequestReceived() &&
                                            <AddFriendButton modifiers="secondary"
                                                             text={yipnyap_translation.add_friend}
                                                             loggedUser={props.loggedUser}
                                                             userID={props.data.id}
                                                             onActionComplete={props.onActionComplete}
                                            />
                                        }

                                        {
                                            friendable.friendRequestSent() &&
                                            <WithdrawFriendRequestButton modifiers="tertiary"
                                                                         text={yipnyap_translation.withdraw_friend}
                                                                         loggedUser={props.loggedUser}
                                                                         userID={props.data.id}
                                                                         onActionComplete={props.onActionComplete}
                                            />
                                        }

                                        {
                                            friendable.friendRequestReceived() &&
                                            <AcceptFriendRequestButton modifiers="secondary"
                                                                       text={yipnyap_translation.accept_friend}
                                                                       loggedUser={props.loggedUser}
                                                                       userID={props.data.id}
                                                                       onActionComplete={props.onActionComplete}
                                            />
                                        }
                                    </React.Fragment>
                                }
                                {
                                    friendable.isFriend() &&
                                    <RemoveFriendButton modifiers="tertiary"
                                                        text={yipnyap_translation.remove_friend}
                                                        loggedUser={props.loggedUser}
                                                        userID={props.data.id}
                                                        onActionComplete={props.onActionComplete}
                                    />
                                }

                                {
                                    yipnyap_constants.plugin_active.buddypress_messages && friendable.isFriend() &&
                                    <ButtonLink modifiers="primary"
                                                text={yipnyap_translation.send_message}
                                                link={`${props.loggedUser.link}settings/messages?user_id=${props.data.id}`}
                                    />
                                }
                            </React.Fragment>
                        }
                    </div>
                }
            </div>
        </div>
    );
}

export {MemberPreviewBig as default};
