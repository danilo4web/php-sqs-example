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
    $result = $sqsClient->receiveMessage([
        'AttributeNames' => ['All'],
        'MaxNumberOfMessages' => 1,
        'QueueUrl' => $queueUrl,
    ]);
    
    if (!empty($result->get("Messages"))) {

        echo $result->get("Messages")[0]['Body'] . PHP_EOL;

        $sqsClient->deleteMessage([
            'QueueUrl' => $queueUrl,
            'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle']
        ]);
        
    } else {
        echo "No messages in queue. \n";
    }
} catch (AwsException $e) {

    error_log($e->getMessage());

}
