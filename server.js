import express from "express";
import { createServer } from 'http';
import cors from 'cors';
import { Server } from 'socket.io';
import Redis from 'ioredis';

const app = express();
const http = createServer(app);
const io = new Server(http, {
    cors: {
      origin: "http://127.0.0.1:8000",
      methods: ["GET", "POST"],
    },
  });
app.use(cors({ origin: 'http://127.0.0.1:8000' }));

const redis = new Redis({
    host: '127.0.0.1', // Replace with your Redis server's IP or hostname
    port: 6379,      // Replace with your Redis server's port
    // Add authentication options if needed
});
let users=[];

http.listen(8005, function(){
    console.log("Listening to port 8005");
});
redis.subscribe('private-channel', function(){
    console.log('subscribed to private channel');
});
redis.on('connect', () => {
    console.log('Connected to Redis');
    redis.publish('test-channel', 'Test message');
});

redis.on('error', (err) => {
    console.error('Redis error:', err);
});
redis.on('message', function(channel, message){
    console.log(`Received message on channel ${channel}: ${message}`);
    try{
        message = JSON.parse(message);
        console.log(message);
        if (channel == 'private-channel') {
            let data = message.data.data;
            let receiver_id = data.receiver_id;
            let event = message.event;

            io.to(`${users[receiver_id]}`).emit(channel + ':' + message.event, data);
        }
    }catch(error){
        console.log(error)
    }

});


io.on('connection', function(socket){
    socket.on("user-connected", function(user_id){
        users[user_id] = socket.id;
        io.emit('updateUserStatus', users);
        console.log("user connected " + user_id);
    });

    socket.on('disconnect', function(){
        const userIds = Object.keys(users);
        const socketId = socket.id;
        userIds.forEach(user_id => {
            if (users[user_id] === socketId) {
                delete users[user_id]; // Remove disconnected user
                io.emit('updateUserStatus', users);
                console.log(`user disconnected: ${user_id}`);
            }
        });
    });
});
