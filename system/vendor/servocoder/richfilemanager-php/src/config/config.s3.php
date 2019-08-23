<?php
/**
 *  RichFilemanager configuration file for S3 storage.
 *
 *	Based on the config file for Local storage.
 *	Contains the options which are specific to S3 storage.
 *
 *	@license	MIT License
 *  @author     Pavel Solomienko <https://github.com/servocoder/>
 *  @copyright	Authors
 */

$config = require 'config.local.php';

/**
 * Default value "false".
 * Whether to store images thumbnails locally (faster; save traffic and requests)
 */
$config['images']['thumbnail']['useLocalStorage'] = false;

/**
 * Default value "true".
 * Whether to perform bulk operations on "folders" (rename/move/copy)
 * NOTE: S3 is not a filesystem, it operates with "objects" and it has no such thing as "folder".
 * When you are performing operation like delete/rename/move/copy on "directory" the plugin actually performs
 * multiple operations for each object prefixed with the "directory" name in the background. The more objects you have
 * in your "directory", the more requests will be sent to simulate the "recursive mode".
 * DELETE requests are not charged so they are not restricted with with option.
 *
 * Links with some explanations:
 * http://stackoverflow.com/a/12523414/1789808
 * http://stackoverflow.com/questions/33363254/aws-s3-rename-directory-object
 * http://stackoverflow.com/questions/33000329/cost-of-renaming-a-folder-in-aws-s3-bucket
 */
$config['allowBulk'] = true;

/**
 * Each bucket or object (file or folder) at S3 storage has an Access Control List (ACL) attached to it as a subresource.
 * It defines which AWS accounts or groups are granted access and the type of access.
 *
 * When you perform create or update operations on S3 object there are 2 ways to deal with ACL:
 *
 * 1. ACL_POLICY_DEFAULT
 * Apply "defaultAcl" policy (see below) to all S3 objects regardless of the operation.
 * Used by default. It's a rough way, but appropriate if all your objects are assumed to share a single ACL policy.
 *
 * 2. ACL_POLICY_INHERIT
 * Inherits the ACL policies of a source/parent object.
 * When your create new folder or upload new file it will take ACL rules of parent object (or bucket if root).
 * When you perform operation on existing S3 object (copy/move/rename) it will preserve ACL rules of source object.
 *
 * NOTE: S3 doesn't provide ACL policies along with object data.
 * An additional GET request will be sent to retrieve ACL policies for each source/parent object.
 * This will result in regression of RFM responsiveness and extra charges of AWS billing.
 * For example, if you copy/move/rename an object that contains 1000 nested objects you will be billed for another 1000 of GET requests.
 * Original discussion: https://github.com/servocoder/RichFilemanager-PHP/issues/6
 */
$config['aclPolicy'] = \RFM\Repository\S3\StorageHelper::ACL_POLICY_DEFAULT;

/**
 * The Server-side encryption algorithm used when storing objects in S3.
 * Valid values: null|AES256|aws:kms
 * http://docs.aws.amazon.com/AmazonS3/latest/dev/serv-side-encryption.html
 * http://docs.aws.amazon.com/AmazonS3/latest/dev/UsingServerSideEncryption.html
 */
$config['encryption'] = null;



/*******************************************************************************
 * S3 SETTINGS
 * Check options description: https://github.com/frostealth/yii2-aws-s3
 ******************************************************************************/

$config['credentials'] = [
    'region' => 'your region',
    'bucket' => 'your aws s3 bucket',
    'endpoint' => null,
    // Aws\Credentials\CredentialsInterface|array|callable
    'credentials' => [
        'key' => 'your aws s3 key',
        'secret' => 'your aws s3 secret',
    ],
    'options' => [
        'use_path_style_endpoint' => false,
    ],
    'defaultAcl' => \RFM\Repository\S3\StorageHelper::ACL_PUBLIC_READ,
    //'cdnHostname' => 'http://example.cloudfront.net',
    'debug' => false, // bool|array
];

return $config;