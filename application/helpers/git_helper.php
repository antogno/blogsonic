<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('getCurrentGitInfo')) {
    /**
     * Retrieves the current Git info such as the URL of the current commit,
     * the commit hash, the current branch, the possible current tag and
     * a label to use in front-end
     * 
     * @return array
     */
    function getCurrentGitInfo()
    {
        $origin = 'https://github.com/antogno/blogsonic/';

        $hash = getCurrentGitCommitHash(false);
        $tag = getCurrentGitTag();
        $branch = getCurrentGitBranch();

        $url = $origin . "tree/$hash";
        $label = '%s';
        if (isCurrentlyInAGitTag()) {
            $url = $origin . "tree/$tag";
            $label = "$tag (%s)";
        } elseif (isCurrentlyInGitHead()) {
            $url = $origin . "tree/$branch";
            $label = "$branch (HEAD)";
        }

        $label = sprintf($label, $hash);

        return compact('url', 'hash', 'branch', 'tag', 'label');
    }
}

if (!function_exists('getCurrentGitCommitHash')) {
    /**
     * Retrieves the current Git commit hash
     *
     * @param bool $full whether to get the full hash or
     * just its first 10 characters.
     * 
     * @return false|string
    */
    function getCurrentGitCommitHash(bool $full = true)
    {
        $output = shell_exec('git rev-parse HEAD');

        if (!is_string($output)) {
            return false;
        }

        $output = trim($output);

        if (!isValidGitCommitHash($output)) {
            return false;
        }

        return $full ? $output : substr($output, 0, 10);
    }
}

if (!function_exists('getCurrentGitBranch')) {
    /**
     * Retrieves the current Git branch
     *
     * @return false|string
    */
    function getCurrentGitBranch()
    {
        $output = shell_exec('git branch --show-current');

        if (!is_string($output)) {
            return false;
        }

        return trim($output);
    }
}

if (!function_exists('getCurrentGitTag')) {
    /**
     * Retrieves the current Git tag (if in a tag)
     *
     * @return false|string
    */
    function getCurrentGitTag()
    {
        $hash = getCurrentGitCommitHash();

        if ($hash === false) {
            return false;
        }

        $tags = getGitTags();

        if (empty($tags)) {
            return false;
        }

        foreach ($tags as $tag) {
            $output = shell_exec("git rev-list -n 1 \"$tag\"");
            
            if (!is_string($output)) {
                continue;
            }

            $output = trim($output);

            if (!isValidGitCommitHash($output)) {
                continue;
            }

            if ($hash === $output) {
                return $tag;
            }
        }

        return false;
    }
}

if (!function_exists('isCurrentlyInAGitTag')) {
    /**
     * Whether you are now in a Git tag or not
     *
     * @return bool
    */
    function isCurrentlyInAGitTag()
    {
        return getCurrentGitTag() !== false;
    }
}

if (!function_exists('isCurrentlyInGitHead')) {
    /**
     * Whether you are now in the HEAD of the current branch
     * or not
     *
     * @return bool
    */
    function isCurrentlyInGitHead()
    {
        $output = shell_exec('git rev-parse HEAD');
            
        if (!is_string($output)) {
            return false;
        }

        $output = trim($output);

        if (!isValidGitCommitHash($output)) {
            return false;
        }

        return getCurrentGitCommitHash() === $output;
    }
}

if (!function_exists('isCurrentlyInDetachedHead')) {
    /**
     * Whether you are in a 'detached HEAD' status or not
     *
     * @return bool
    */
    function isCurrentlyInDetachedHead()
    {
        return getCurrentGitBranch() === false;
    }
}

if (!function_exists('getGitTags')) {
    /**
     * Retrieves the Git tags list, if there are any
     *
     * @return string[]
    */
    function getGitTags()
    {
        $tags = [];

        $output = shell_exec("git tag");

        if (!is_string($output)) {
            return $tags;
        }

        $output = trim(preg_replace('/\s+/', ' ', $output));

        $tags = explode(' ', $output);

        return $tags;
    }
}

if (!function_exists('isValidGitCommitHash')) {
    /**
     * Checks if the given string is a valid Git commit
     * hash
     *
     * @param string $hash string to check.
     * 
     * @return bool
    */
    function isValidGitCommitHash(string $hash)
    {
        $hash = trim($hash);

        if (strlen($hash) !== 40) {
            return false;
        }

        $output = shell_exec("git cat-file -t $hash");

        if (!is_string($output)) {
            return false;
        }

        return trim($output) === 'commit';
    }
}
