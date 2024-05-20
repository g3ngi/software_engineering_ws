# Use the official Node.js 14 image as base
FROM node:14

WORKDIR /usr/src/

COPY . .

# Install dependencies
RUN npm install
# CMD ["sleep", "infinity"]


# Copy the rest of the application code to the working directory
COPY . .

# Expose the port your app runs on
EXPOSE 3000
# Start the applicatio

CMD ["npm", "start"]
