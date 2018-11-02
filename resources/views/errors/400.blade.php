@extends ('layouts.base')
@section ('content')
    <div class="container main-visual">
        <div class="row">
            <?php
            $statusCode = $exception->getStatusCode();
            switch ($statusCode) {
            case 400:
                $message = 'Bad Request';
                break;
            case 401:
                $message = '認証に失敗しました';
                break;
            case 403:
                $message = 'アクセス権がありません';
                break;
            case 405:
                $message = '許可されていないリクエストです';
            case 404:
                $message = '存在しないページです';
                break;
            case 408:
                $message = 'タイムアウトです';
                break;
            case 414:
                $message = 'リクエストURIが長すぎます';
                break;
            default:
                $message = 'エラー';
                break;
            }
            $message .= "\n". $exception->getMessage();
            ?>
            <h2>{{ $statusCode }}</h2>
            <h4>{{ $message }}</h4>
        </div>
    </div>
@endsection
