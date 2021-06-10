<?php

require_once "vendor/autoload.php";

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

$queueUrl = "https://sqs.us-east-1.amazonaws.com/355331038472/queue-example";

$sqsClient = new SqsClient([
    'profile' => 'default',
    'region' => 'us-east-1',
    'version' => '2012-11-05'
]);

try {

    $messageBody = 'Hello World!';

    $sqsClient->sendMessage(array(
        'QueueUrl' => $queueUrl,
        'MessageBody' => $messageBody,
    ));

} catch (AwsException $e) {

    error_log($e->getMessage());

}
