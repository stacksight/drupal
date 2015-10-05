<?php

class stacksight_backup_migrate_filter extends backup_migrate_filter
{

    public $category = 'backups';
    public $title = 'Great Backups Plugin';
    public $desc = 'Great Backups Plugin description';
    public $plugin_url = 'http://stacksight.io/wp-admin?plugin=stacksight';

    public $timezone = 'UTC';

    private $_ss_client;

    private $_object = [];
    private $_widgets = [];

    const BACKUP_TYPE = 'backup_item';
    const BACKUP_TITLE = 'Your backups';
    const BACKUP_DESC = 'For information, updates and documentation, please visit the AIO WP Security & Firewall Plugin Page';

    public function __construct()
    {
        global $ss_client;
        $this->_ss_client = $ss_client;
    }


    // executed after a failed Backup
    public function backup_fail($settings, $message, $params)
    {
        drupal_set_message('Backup failed!');
        die();
    }

    // executed after a successful Backup
    public function backup_succeed($settings, $message, $params)
    {
        $widget_info = [
            'type' => self::BACKUP_TYPE,
            'title' => self::BACKUP_TITLE,
            'desc' => self::BACKUP_TYPE,
            'data' => [

            ]
        ];
        $this->_buildWidget($params, $widget_info, 1);
        $this->_buildObject();
        $this->_send();
        drupal_set_message('Backup succeeded!');
    }

    // executed after a failed Restore
    public function restore_fail($settings, $message, $params)
    {
        drupal_set_message('Restore failed!');
//        die();
    }

    // executed after a successful Restore
    public function restore_succeed($settings, $message, $params)
    {

    }

    /**
     * This function is called on a backup file after the backup has been completed.
     */
    public function backup($file, $settings)
    {
        return $file;
    }

    /**
     * This function is called on a backup file before importing it.
     */
    public function restore($file, $settings)
    {
        return $file;
    }

    /**
     * This function is called immediately prior to backup.
     */
    public function pre_backup($file, $settings)
    {

    }

    /**
     * This function is called immediately post backup.
     */
    public function post_backup($file, $settings)
    {

    }

    private function _buildWidget($info, $widget_info, $status = 1)
    {
        $widget_info['order'] = sizeof($this->_widgets) + 1;
        $widget_info['group'] = 1;
        $widget_info['data'] = [
            'timestamp' => $this->_getUTCNow(),
            'file' => $info['%file'],
            'dest' => $info['%dest'],
            'source' => $info['%source'],
            'size' => $info['%size'],
            'links' => $info['!links']
        ];
        $this->_widgets[] = $widget_info;
    }

    private function _buildObject()
    {
        $this->_object = [
            'category' => $this->category,
            'title' => $this->title,
            'desc' => $this->desc,
            'widgets' => $this->_widgets,
            'plugin_url' => $this->plugin_url
        ];
    }

    private function _getUTCNow()
    {
        $time = new DateTime();
        $timezone = new DateTimeZone($this->timezone);
        $time->setTimezone($timezone);
        return $time->getTimestamp();
    }

    private function _send()
    {
        drupal_set_message('<pre>'.print_r($this->_object, true).'</pre>');
//        die();
    }

}