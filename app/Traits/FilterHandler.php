<?php

namespace App\Traits;

trait FilterHandler
{
    public function FilterURL($filter_a = null,$filter_c = null,$filter_d = null, $filter_page = null)
    {
        $latest_idea_url = url()->current();
        $most_popular_url = url()->current();
        $most_viewed_url = url()->current();

        if ($filter_a && $filter_c && $filter_d) {
            $latest_idea_url .= '?a=' . $filter_a . '&c=' . $filter_c . '&d=' . $filter_d . '&sortby=latest_idea' . ($filter_page ? '&page=' . $filter_page : '');
            $most_popular_url .= '?a=' . $filter_a . '&c=' . $filter_c . '&d=' . $filter_d . '&sortby=most_popular' . ($filter_page ? '&page=' . $filter_page : '');
            $most_viewed_url .= '?a=' . $filter_a . '&c=' . $filter_c . '&d=' . $filter_d . '&sortby=most_viewed' . ($filter_page ? '&page=' . $filter_page : '');
        } else if ($filter_a && $filter_c) {
            $latest_idea_url .= '?a=' . $filter_a . '&c=' . $filter_c . '&sortby=latest_idea' . ($filter_page ? '&page=' . $filter_page : '');
            $most_popular_url .= '?a=' . $filter_a . '&c=' . $filter_c . '&sortby=most_popular' . ($filter_page ? '&page=' . $filter_page : '');
            $most_viewed_url .= '?a=' . $filter_a . '&c=' . $filter_c . '&sortby=most_viewed' . ($filter_page ? '&page=' . $filter_page : '');
        } else if ($filter_c && $filter_d) {
            $latest_idea_url .= '?c=' . $filter_c . '&d=' . $filter_d . '&sortby=latest_idea' . ($filter_page ? '&page=' . $filter_page : '');
            $most_popular_url .= '?c=' . $filter_c . '&d=' . $filter_d . '&sortby=most_popular' . ($filter_page ? '&page=' . $filter_page : '');
            $most_viewed_url .= '?c=' . $filter_c . '&d=' . $filter_d . '&sortby=most_viewed' . ($filter_page ? '&page=' . $filter_page : '');
        } else if($filter_d && $filter_a) {
            $latest_idea_url .= '?a=' . $filter_a . '&d=' . $filter_d . '&sortby=latest_idea' . ($filter_page ? '&page=' . $filter_page : '');
            $most_popular_url .= '?a=' . $filter_a . '&d=' . $filter_d . '&sortby=most_popular' . ($filter_page ? '&page=' . $filter_page : '');
            $most_viewed_url .= '?a=' . $filter_a . '&d=' . $filter_d . '&sortby=most_viewed' . ($filter_page ? '&page=' . $filter_page : '');
        } else if ($filter_a) {
            $latest_idea_url .= '?a=' . $filter_a . '&sortby=latest_idea' . ($filter_page ? '&page=' . $filter_page : '');
            $most_popular_url .= '?a=' . $filter_a . '&sortby=most_popular' . ($filter_page ? '&page=' . $filter_page : '');
            $most_viewed_url .= '?a=' . $filter_a . '&sortby=most_viewed' . ($filter_page ? '&page=' . $filter_page : '');
        } else if ($filter_c) {
            $latest_idea_url .= '?c=' . $filter_c . '&sortby=latest_idea' . ($filter_page ? '&page=' . $filter_page : '');
            $most_popular_url .= '?c=' . $filter_c . '&sortby=most_popular' . ($filter_page ? '&page=' . $filter_page : '');
            $most_viewed_url .= '?c=' . $filter_c . '&sortby=most_viewed' . ($filter_page ? '&page=' . $filter_page : '');
        } else if($filter_d) {
            $latest_idea_url .= '?d=' . $filter_d . '&sortby=latest_idea' . ($filter_page ? '&page=' . $filter_page : '');
            $most_popular_url .= '?d=' . $filter_d . '&sortby=most_popular' . ($filter_page ? '&page=' . $filter_page : '');
            $most_viewed_url .= '?d=' . $filter_d . '&sortby=most_viewed' . ($filter_page ? '&page=' . $filter_page : '');
        }  else {
            $latest_idea_url .= '?sortby=latest_idea' . ($filter_page ? '&page=' . $filter_page : '');
            $most_popular_url .= '?sortby=most_popular' . ($filter_page ? '&page=' . $filter_page : '');
            $most_viewed_url .= '?sortby=most_viewed' . ($filter_page ? '&page=' . $filter_page : '');
        }

        return [$latest_idea_url, $most_popular_url, $most_viewed_url];
    }
}
