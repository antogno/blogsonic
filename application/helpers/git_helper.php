<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('getGitInfo')) {
    /**
     * Retrieves the current Git info such as the current tag (if in a tag,
     * alternatively the current branch) in the `label` key, and the URL of the
     * Git repository in the `url` key
     * 
     * @return array
     */
    function getGitInfo()
    {
        $git = new \antogno\GitInfo\GitInfo;

        $url = 'https://github.com/antogno/blogsonic';

        try {
            $tag = $git->getCurrentTag()->getName();
            $url .= "/tree/$tag";
            $label = $tag;
        } catch (Exception $e) {
            $branch = $git->getCurrentBranch()->getName();
            $url .= "/tree/$branch";
            $hash = $git->getCurrentCommit()->getShortHash();
            $label = "$branch ($hash)";
        }


        return [
            'label' => $label,
            'url' => $url
        ];
    }
}
