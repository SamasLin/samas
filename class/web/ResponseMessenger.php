<?php
class ResponseMessenger
{

    CONST STATUS_SUCCESS = 'success';
    CONST STATUS_FAIL    = 'fail';
    CONST STATUS_DENY    = 'deny';
    CONST STATUS_EMPTY   = 'empty';
    CONST STATUS_UNKNOWN = 'unknown';

    private static $status_map = array(
        self::STATUS_SUCCESS => array(
            'code'    => 0,
            'message' => '成功'
        ),
        self::STATUS_FAIL => array(
            'code'    => 1,
            'message' => '失敗'
        ),
        self::STATUS_DENY => array(
            'code'    => 2,
            'message' => '無法存取'
        ),
        self::STATUS_EMPTY => array(
            'code'    => 3,
            'message' => '資料不存在'
        ),
        self::STATUS_UNKNOWN => array(
            'code'    => 999,
            'message' => '狀態未定義'
        )
    );

    public static function json($status, $message = '', $content = '')
    {

        $code = self::$status_map[self::STATUS_UNKNOWN]['code'];
        $text = self::STATUS_UNKNOWN;
        $output_message = self::$status_map[self::STATUS_UNKNOWN]['message'];

        if (!isset(self::$status_map[$status])) {
            $content = array(
                'status'  => $status,
                'message' => $message,
                'content' => $content
            );
        } else {
            $code = self::$status_map[$status]['code'];
            $text = $status;
            if (empty($message)) {
                $output_message = self::$status_map[$status]['message'];
            } else {
                $output_message = $message;
            }
        }

        $return_array = array(
            'message' => $output_message,
            'content' => $content,
            'status'  => array(
                'code' => $code,
                'text' => $text
            )
        );

        header('Content-type: application/json');
        echo json_encode($return_array, JSON_PRETTY_PRINT);

    }// end function json

}// end class ResponseMessenger
