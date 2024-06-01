$(document).ready(function() {
    var form = $('#messageForm');
    var messageInput = $('#messageInput');
    var chatBox = $('#chatbox');

    form.on('submit', function(event) {
        event.preventDefault();
        var message = messageInput.val().trim().replace(/\n/g, ' ');
        if (message) {
            sendMessage(message);
            messageInput.val('');
        } else {
            messageInput.val('');
        }
    });

    function sendMessage(message) {
        $.ajax({
            url: 'chatmsg.php',
            type: 'POST',
            data: { message: message },
            success: function(response) {
                if (response === 'SUCCESS') {
                    messageInput.val(''); // Clear the input after sending
                    pollMessages(); // Reload messages after sending
                } else {
                    console.error('Failed to send message.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) { // Handle session timeout specifically
                    window.location.href = 'login.php';
                } else {
                    console.error('Failed to send message.');
                }
            }
        });
    }

    function appendMessage(person, message, time) {

        if (person === username) {
            // message from user, add to .mine class
            chatBox.append('<div class="message mine">' + '<div class="message-header">' + '<span class="message-person">' + person + '</span>' + '<span class="message-time">' + time + '</span>' + '</div>' + '<div class="message-body">' + message + '</div>' + '</div>');
        } else {
            // message from others, add to .others class
            chatBox.append('<div class="message others">' + '<div class="message-header">' + '<span class="message-person">' + person + '</span>' + '<span class="message-time">' + time + '</span>' + '</div>' + '<div class="message-body">' + message + '</div>' + '</div>');
        }
    }

    function pollMessages() {
        $.ajax({
            url: 'chatmsg.php',
            type: 'GET',
            success: function(response) {
                var messages = JSON.parse(response);
                chatBox.empty(); // Clear chatbox and reload all messages
                $.each(messages, function(index, msg) {
                    appendMessage(msg.person, msg.message, msg.formatted_time);
                });
                // Scroll to the bottom of the chatbox
                chatBox.scrollTop(chatBox[0].scrollHeight);
            },
            error: function(xhr) {
                if (xhr.status === 401) { // Handle session timeout specifically
                    console.error('Session expired.');
                    window.location.href = 'login.php'; // Redirect to login page
                } else {
                    console.error('Failed to poll messages.');
                }
            }
        });
    }

    setInterval(pollMessages, 5000); // Poll every 5 seconds
});