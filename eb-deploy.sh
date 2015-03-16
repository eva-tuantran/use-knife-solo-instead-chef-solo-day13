#!/bin/bash

PROFILE=ops
# ElasticBeanstalk SETTING
APPLICATION_NAME=rakuichi-rakuza
ENVIRONMENT_NAME=rakuichi-rakuza-dev

VERSION=$(date '+%Y-%m-%d-%H-%M')
TARGET_FILE=$APPLICATION_NAME.${VERSION}.zip
TARGET_PATH=/tmp

# REGION
REGION=ap-northeast-1

# S3 SETTING
BUCKET=elasticbeanstalk-ap-northeast-1-823565053938


echo "archiving files."
zip -qr $TARGET_PATH/$TARGET_FILE public fuel oil composer.json composer.lock .ebextensions
echo "uploading to s3."
aws --profile $PROFILE --region $REGION  s3               cp  $TARGET_PATH/$TARGET_FILE s3://$BUCKET/$TARGET_FILE
echo "Beanstalk loading from s3."
aws --profile $PROFILE --region $REGION  elasticbeanstalk create-application-version --application-name $APPLICATION_NAME --version-label $VERSION --source-bundle S3Bucket=$BUCKET,S3Key=${TARGET_FILE}
echo "Beanstalk deploy to Environment"
aws --profile $PROFILE --region $REGION  elasticbeanstalk update-environment --environment-name $ENVIRONMENT_NAME --version-label $VERSION

rm -f $TARGET_PATH/$TARGET_FILE
