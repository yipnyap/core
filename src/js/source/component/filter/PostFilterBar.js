import React, {useState, useEffect} from 'react';

import IconSVG from '../icon/IconSVG';

import GridOptions from '../grid/GridOptions';

import {ucfirst} from '@legacy/utils/core';

import * as postRouter from '@legacy/router/post/post-router';

function PostFilterBar(props) {
    const [categories, setCategories] = useState([]);
    const [category, setCategory] = useState(props.extraFilters.category || 0);
    const [filterBy, setFilterBy] = useState('date');
    const [orderBy, setOrderBy] = useState('DESC');
    const [postType, setPostType] = useState(0);

    const postTypes = props.extraFilters.postTypes;
    const postTypeFilterIsEnabled = yipnyap_constants.settings.post_type_filter_display_is_enabled && (postTypes.length > 1);

    useEffect(() => {
        if (!props.hideCategories) {
            postRouter.getCategories((categories) => {
                

                setCategories(categories);
            });
        }
    }, []);

    useEffect(() => {
        const newFilters = {
            category,
            orderby: filterBy,
            order: orderBy
        };

        if (postTypeFilterIsEnabled) {
            if (postType === 0) {
                newFilters.post_type = postTypes;
            } else {
                newFilters.post_type = [postTypes[postType - 1]];
            }
        }

        props.applyFilters(newFilters);
    }, [category, filterBy, orderBy, postType]);

    const showCategoryFilter = !props.extraFilters.category;

    return (
        <div className="section-filters-bar v2">
            <div className="section-filters-bar-actions full">
                <form className="form">
                    <div className="form-row split">
                        {
                            showCategoryFilter &&
                            <div className="form-item">
                                <div className="form-select">
                                    <label>{yipnyap_translation.category}</label>
                                    <select name="category" value={category} onChange={(e) => {
                                        setCategory(e.target.value);
                                    }}>
                                        <option value="0">{yipnyap_translation.all_categories}</option>
                                        {
                                            categories.map((category) => {
                                                return (
                                                    <option key={category.id}
                                                            value={category.id}>{category.name}</option>
                                                );
                                            })
                                        }
                                    </select>
                                </div>
                            </div>
                        }

                        <div className="form-item">
                            <div className="form-select">
                                <label>{yipnyap_translation.filter_by}</label>
                                <select name="orderby" value={filterBy} onChange={(e) => {
                                    setFilterBy(e.target.value);
                                }}>
                                    <option value="date">{yipnyap_translation.date}</option>
                                    <option value="comment_count">{yipnyap_translation.popularity}</option>
                                </select>
                            </div>
                        </div>

                        <div className="form-item">
                            <div className="form-select">
                                <label>{yipnyap_translation.order_by}</label>
                                <select name="order" value={orderBy} onChange={(e) => {
                                    setOrderBy(e.target.value);
                                }}>
                                    <option value="DESC">{yipnyap_translation.descending}</option>
                                    <option value="ASC">{yipnyap_translation.ascending}</option>
                                </select>
                            </div>
                        </div>

                        {
                            postTypeFilterIsEnabled &&
                            <div className="form-item">
                                <div className="form-select">
                                    <label>{yipnyap_translation.type}</label>
                                    <select name="postType" value={postType} onChange={(e) => {
                                        setPostType(e.target.value);
                                    }}>
                                        <option value="0">{yipnyap_translation.all}</option>
                                        {
                                            postTypes.map((postType, i) => {
                                                return (
                                                    <option key={i} value={i + 1}>{ucfirst(postType)}</option>
                                                );
                                            })
                                        }
                                    </select>
                                </div>
                            </div>
                        }
                    </div>
                </form>
            </div>

            <div className="section-filters-bar-actions">
                <GridOptions gridTypes={['big', 'small', 'list']}
                             activeGrid={props.gridType}
                             onGridOptionClick={props.setGrid}
                />
            </div>
        </div>
    );
}

export {PostFilterBar as default};
