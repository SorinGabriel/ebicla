/*
*
*  Push Notifications codelab
*  Copyright 2015 Google Inc. All rights reserved.
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*      https://www.apache.org/licenses/LICENSE-2.0
*
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*  limitations under the License
*
*/

/* eslint-env browser, es6 */

'use strict';

const applicationServerPublicKey = 'BHNxH4G6agx-XsPBP-90jxHj9cXbn6vUVqWiDhGPpiJXy8el69RfWOzp5fs_ZJiU6jl8QTxoNdASPOOYXhuKbUw';

const pushButton = document.querySelector('.js-push-btn');

let isSubscribed = false;
let swRegistration = null;

function urlB64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
    navigator.serviceWorker.register('serviceworker.js')
    .then(function(swReg) {
        swRegistration = swReg;
    })
    .catch(function(error) {
        console.error('Service Worker Error', error);
    });
} else {
    pushButton.style.display = 'none';
}

function initializeUI() {
    pushButton.addEventListener('click', function() {
        pushButton.disabled = true;
        if (isSubscribed) {
            unsubscribeUser();
    } else {
            subscribeUser();
        }
    });
  
    // Set the initial subscription value
    swRegistration.pushManager.getSubscription()
    .then(function(subscription) {
        isSubscribed = !(subscription === null);
        updateSubscriptionOnServer(subscription);
        updateBtn();
    });
}

function updateBtn() {
    if (Notification.permission === 'denied') {
        pushButton.classList.remove("active");
        updateSubscriptionOnServer(null);
        return;
    }
  
    if (isSubscribed) {
        pushButton.classList.add("active");
    } else {
        pushButton.classList.remove("active");
    }
}

navigator.serviceWorker.register('serviceworker.js')
    .then(function(swReg) {
        swRegistration = swReg;
        initializeUI();
    })

    function subscribeUser() {
        const applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
        swRegistration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: applicationServerKey
        })
        .then(function(subscription) {
          updateSubscriptionOnServer(subscription);
          isSubscribed = true;
          updateBtn();
        })
        .catch(function(err) {
          updateBtn();
        });
    }

    function updateSubscriptionOnServer(subscription) {
        if (subscription) {
            $.ajax({
                method: 'GET',
                url: 'wp-content/themes/ebicla/functions/notificationsAPI/api.php',
                data: {
                    path: 'RegisterSubscription',
                    params: JSON.stringify(subscription)
                },
                success: function(json){
                    console.log(json);
                }
            });
        }
    }

    pushButton.addEventListener('click', function() {
        pushButton.disabled = true;
        if (isSubscribed) {
          unsubscribeUser();
        } else {
          subscribeUser();
        }
    });

    function unsubscribeUser() {
        swRegistration.pushManager.getSubscription()
        .then(function(subscription) {
            if (subscription) {
                return subscription.unsubscribe();
            }
        })
        .catch(function(error) {
            console.log('Error unsubscribing', error);
        })
        .then(function() {
            updateSubscriptionOnServer(null);
            isSubscribed = false;
            updateBtn();
        });
    }

        swRegistration.pushManager.getSubscription()
        .then(function(subscription) {
            if (subscription) {
                // TODO: Tell application server to delete subscription
                return subscription.unsubscribe();
            }
        })
        .catch(function(error) {
            console.log('Error unsubscribing', error);
        })