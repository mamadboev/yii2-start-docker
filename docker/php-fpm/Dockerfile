FROM usanjar/yii2-php-fpm:latest

ARG GITHUB_AUTH_TOKEN

RUN composer config -g github-oauth.github.com "${GITHUB_AUTH_TOKEN}"