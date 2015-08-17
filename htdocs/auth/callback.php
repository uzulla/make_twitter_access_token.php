<?php
session_start();
require_once __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config.php";

$Opauth = new Opauth($opauth_config, false);
$response = $_SESSION['opauth'];
unset($_SESSION['opauth']);

if (array_key_exists('error', $response)) {
    echo '<h1>エラーが発生しました</h1>';
    echo '<p>外部サービスで認証ができませんでした、認証をやりなおしてください。</p>';
    exit;
}

if (empty($response['auth']) || empty($response['timestamp']) || empty($response['signature']) || empty($response['auth']['provider']) || empty($response['auth']['uid'])) {
    echo '<h1>エラーが発生しました</h1>';
    echo '<p>外部サービスと連携に失敗しました、しばらく時間をおいてやりなおしてください。(パターン１)</p>';
    exit;
} elseif (!$Opauth->validate(sha1(print_r($response['auth'], true)), $response['timestamp'], $response['signature'], $reason)) {
    echo '<h1>エラーが発生しました</h1>';
    echo '<p>外部サービスと連携に失敗しました、しばらく時間をおいてやりなおしてください。(パターン２)</p>';
    exit;
} else {
    /**
     * It's all good.
     */
    var_dump($response['auth']['credentials']);
}
