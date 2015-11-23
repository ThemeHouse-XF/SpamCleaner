<?php

/**
 *
 * @see XenForo_DataWriter_Discussion_Thread
 */
class ThemeHouse_SpamCleaner_Extend_XenForo_DataWriter_Discussion_Thread extends XFCP_ThemeHouse_SpamCleaner_Extend_XenForo_DataWriter_Discussion_Thread
{

    /**
     *
     * @see XenForo_DataWriter_Discussion_Thread
     */
    public function delete()
    {
        if (!empty($GLOBALS['XenForo_SpamHandler_Thread'])) {
            $spamHandler = $GLOBALS['XenForo_SpamHandler_Thread'];

            $xenOptions = XenForo_Application::get('options');

            if ($xenOptions->th_spamCleaner_reassignThreadOnDelete) {
                /* @var $postModel XenForo_Model_Post */
                $postModel = $this->_getPostModel();

                $posts = $postModel->getPostsInThreadSimple($this->get('thread_id'), false);

                $firstPost = array();
                $lastPost = array();
                $replyCount = -1;
                foreach ($posts as $post) {
                    if ($post['user_id'] == $this->get('user_id')) {
                        /* @var $dw XenForo_DataWriter_DiscussionMessage_Post */
                        $dw = XenForo_DataWriter::create('XenForo_DataWriter_DiscussionMessage_Post');
                        $dw->setOption(XenForo_DataWriter_DiscussionMessage_Post::OPTION_UPDATE_PARENT_DISCUSSION, true);
                        $dw->setExistingData($post);
                        $dw->delete();
                        continue;
                    }
                    if ($post['message_state'] == 'visible') {
                        $replyCount++;
                        if (!$firstPost) {
                            $firstPost = $post;
                        }
                        $lastPost = $post;
                    }
                }

                if ($replyCount >= 0) {
                    $this->rebuildDiscussionCounters($replyCount, $firstPost['post_id'], $lastPost['post_id']);
                    $this->save();

                    return false;
                }
            }
        }

        return parent::delete();
    } /* END delete */
}