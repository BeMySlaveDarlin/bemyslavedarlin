#!/usr/bin/env bash
openssl genrsa -des3 -out "${PWD}/var/ssl/root-ca.key" 2048
openssl req -x509 -new -key "${PWD}/var/ssl/root-ca.key" -sha256 -days 3650 -out "${PWD}/var/ssl/root-ca.pem" -passout pass:123456
