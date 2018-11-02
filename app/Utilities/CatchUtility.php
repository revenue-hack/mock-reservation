<?php
namespace App\Utilities;

class CatchUtility
{
    /**
     * エラーログ吐き出し関数
     * @param string $message message
     * @param array $data チェックする目標物
     * @param string $level logのレベル
     * (emergency,alert,critical,error,warning,notice,info,debug)
     * @return void
     */
    public function reportLog($message, $data, $level = 'error')
    {

        // route取得
        $route = \Route::getCurrentRoute()->getActionName();
        // messageにURIを入れる
        $message = sprintf("%s %s %s", $this->getUri(), $route, $message);
        switch($level) {
            case "emergency":
                \Log::emergency($message, $data);
                break;
            case "alert":
                \Log::alert($message, $data);
                break;
            case "critical":
                \Log::critical($message, $data);
                break;
            case "error":
                \Log::error($message, $data);
                break;
            case "warning":
                \Log::warning($message, $data);
                break;
            case "notice":
                \Log::notice($message, $data);
                break;
            case "info":
                \Log::info($message, $data);
                break;
            case "debug":
                \Log::debug($message, $data);
                break;
            default:
                \Log::error($message, $data);
                break;
        }
    }

    /**
     * error catch関数
     * @param string $logMessage ログエラーメッセージ
     * @param array $data logに出力するdata
     * @param int $statusCode ステータスコード
     * @param string $viewMessage 画面に表示するエラーメッセージ
     *
     */
    public function catchError($logMessage = 'data not found', $data = [], $statusCode = 404, $viewMessage = null)
    {

        $logMessage = $statusCode. " ". $logMessage;
        // 4系or5系かどうか判定
        if (preg_match('/^4[0-9]{2}$/', $statusCode)) {
            $status = 4;
        } elseif (preg_match('/^5[0-9]{2}$/', $statusCode)) {
            $status = 5;
        }
        // logが出力
        if ($status === 4) {
            // 4系はlevel=errorで出力
            self::reportLog($logMessage, $data);
        } elseif ($status === 5) {
            // 5系はlevel=criticalで出力
            self::reportLog($logMessage, $data, 'critical');
        }
        // Exception設定
        if (is_null($viewMessage)) {
            abort($statusCode);
        } else {
            abort($statusCode, $viewMessage);
        }
    }

    /**
     * URI取得
     * @param void
     * @return string URI
     *
     */
    private function getUri()
    {

        return $_SERVER["REQUEST_URI"];
    }
}
