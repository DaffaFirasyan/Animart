<?php

/**
 * Vercel Serverless Entry Point
 *
 * This file acts as the single entry point for all requests
 * coming into the Vercel serverless function.
 *
 * We simply load the main entry point of our Laravel application,
 * which is located in /public/index.php.
 */

require __DIR__ . '/../public/index.php';