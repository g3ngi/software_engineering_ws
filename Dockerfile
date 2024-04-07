# Use the official Node.js 14 image as base
FROM node:14

COPY ./app /usr/src/app


# Set the working directory inside the container
WORKDIR /usr/src/app

# Install dependencies
RUN npm install
# CMD ["sleep", "infinity"]
RUN npm install -g express 


# Copy the rest of the application code to the working directory
COPY . .

# Expose the port your app runs on
EXPOSE 3000
# Start the application

CMD ["npm", "start"]
