#!/bin/sh

cd $(dirname $0)
sass --style expanded --watch scss/layout.scss:css/layout.css