#!/usr/bin/env bash
openssl req -new -sha256 -nodes -out "${PWD}/deploy/ssl/server.csr" -newkey rsa:2048 -keyout "${PWD}/var/ssl/server.key" -config "${PWD}/deploy/ssl/server.csr.cnf"
openssl x509 -req -in "${PWD}/deploy/ssl/server.csr" -CA "${PWD}/var/ssl/root-ca.pem" -CAkey "${PWD}/var/ssl/root-ca.key" -CAcreateserial -out "${PWD}/var/ssl/server.crt" -days 3650 -sha256 -extfile "${PWD}/deploy/ssl/domains.ext" -passin pass:123456
