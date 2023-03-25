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

        try {
            $label = $git->getCurrentTag()->getName();
        } catch (Exception $e) {
            $label = $git->getCurrentBranch()->getName() . ' (' . $git->getCurrentCommit()->getShortHash() .  ')';
        }

        return [
            'label' => $label,
            'url' => $git->getRemote('origin')->getUrl()
        ];
    }
}
