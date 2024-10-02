<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About The API

This API will serve for powering IoT modules for clients

## Structure

Admin Table will house the admins of the API

Client table houses information concerning the client

Users Table houses the users which are tied to a client. Each user has a role and can also have a permission. There is Viewing and Operation permissions that will control whether a particular user can view or view and operate the IoT app. A user also has roles and can be super-admin,
admin or user. an admin without any permission can only do admin things without viewing the IoT or oerating it

A user will be attached to profiles and can only see the profiles that he/she is attached to

Profile creates a niche that the client deployed IoT operation and modules on. a client can have multiple Profiles

A Module belongs to a Profile, each location that its deployed on should be a module

A Sub Module belongs to a module and each batch of information sent to the API will be a sub_module. A Submodule will have many Components

A Component will represent a device that an IoT device is installed on

Parameters are created generally in the application

Categories are created which every component will belong to
