---
layout: post
title: Be Your Own Certificate Authority
created: 2018-10-01 11:13:00 -0800
tags:
- OpenSSL
- Certificates
---
# Be Your Own Certificate Authority (CA)

This how-to documents the commands used to generate certificates and other artifacts as well as appropriate secret-handling instructions.

These steps assume that you have a secured computer _A_ as well as one or more web servers, _B_ etc.

Values:

* `rootca`: root CA name, e.g. `myca`
* `myserver`: server, e.g. `host`
* `myserverdns`: server DNS name, e.g. `somedomain.org`

## Root CA

The root CA key and certificate constitute the root of your trust hierarchy. You will only generate these materials once. From these materials, you can then generate an arbitrary number of _derived_ certificates for individual web sites:

### Private key

You _must_ provide a secure, secret passphrase for this private key. Run the following command on _A_:

```
openssl genrsa -des3 -out rootca.key 2048
```

Notes:

* Input files: (none)
* Output file: `rootca.key` (root CA private key)
* Output file is a secret
* Output file must be stored in a secure location
* All subsequent usage of `rootca.key` to perform certificate signing will require the secret passphrase

### Certificate

Run the following command on _A_:

```
openssl req \
    -x509 \
    -new \
    -nodes \
    -key rootca.key \
    -sha256 \
    -days 1825 \
    -subj "/C=US/ST=Washington/L=Bothell/O=Richard Cook CA/CN=rcook.org/emailAddress=rcook@rcook.org" \
    -out rootca.pem
```

Notes:

* Input file: `rootca.key`
* Output file: `rootca.pem` (root CA certificate)
* Output file is not a secret
* Output file can be installed in your browser (see _Install root CA certificate in Chrome_)

## Server

These steps generate a certificate that allows one or more derived, or subsidiary, web servers to securely identify themselves to clients by deriving trust from the root CA we set up previously. The following steps will refer to a given web server as _B_.

### Private key

Run the following command on _B_:

```
openssl genrsa -out myserver.key 2048
```

Notes:

* Input files: (none)
* Output file: `myserver.key` (server private key)
* Output file is a secret
* Output file should not leave _B_

### Certificate-signing request

Run the following command on _B_:

```
openssl req \
    -new \
    -key myserver.key \
    -subj "/C=US/ST=Washington/L=Bothell/O=myserverdns Services/CN=myserverdns/emailAddress=rcook@rcook.org" \
    -out myserver.csr
```

Notes:

* Input files: `myserver.key`
* Output: `myserver.csr` (server certificate-signing request)
* Output file is not a secret
* Output file can be transferred to _A_ and deleted from _B_ after that

### Configuration file

Run the following command on _A_:

```
cat << EOF > myserver.cnf
authorityKeyIdentifier = keyid, issuer
basicConstraints = CA:FALSE
keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
subjectAltName = @alt_names

[alt_names]
DNS.1 = myserverdns
EOF
```

Notes:

* Input files: (none)
* Output file: `myserver.cnf` (server certificate configuration)
* Output file describes the certificate and defines the DNS name that will be covered by the resulting certificate

### Certificate

Run the following command on _A_:

```
openssl x509 \
    -req \
    -in myserver.csr \
    -CA rootca.pem \
    -CAkey rootca.key \
    -CAcreateserial \
    -out myserver.crt \
    -days 1825 \
    -sha256 \
    -extfile myserver.cnf
```

Notes:

* Input files: `rootca.key`, `rootca.pem`, `myserver.cnf`, `myserver.csr`
* Output: `rootca.srl` (root CA serial number), `myserver.crt` (server certificate)
* This will require the root CA secret passphrase
* Copy the server certificate back to _B_

## Install root CA certificate in Chrome

* Start Chrome
* Open _Settings_ menu item
* Expand _Advanced_ section
* Click _Manage certificates_
* Click _Authorities_ tab
* Click _IMPORT_
* Locate `rootca.pem` and click _Open_
* Check _Trust this certificate for identifying websites_
* Click _OK_
