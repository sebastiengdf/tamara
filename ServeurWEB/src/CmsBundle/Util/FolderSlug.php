<?php

namespace CmsBundle\Util;

class FolderSlug
{
    //------------------------------------------------------------------------------------------------------------------
    //	getFolderSlug
    //------------------------------------------------------------------------------------------------------------------

    /**
     *
     * @param type $pageLink
     * @return type
     */
    public function getFolderSlug($pageLink)
    {
        // recuperation du folder et du slug (le slug est la derniere partie apres un slash)
        $pageLink = explode("/", $pageLink);

        if (sizeof($pageLink) > 1) // on a un dossier
        {
            $folder = '';
            for ($i = 0; $i < sizeof($pageLink) - 1; $i++) {
                $folder .= $pageLink[$i]."/";
            }
            $folder = rtrim($folder, '/');
            $slug = end($pageLink);
        } else {
            $folder = null;
            $slug = $pageLink[0];
        }

        return array('folder' => $folder, 'slug' => $slug);
    }
}