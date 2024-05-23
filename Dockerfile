# Use the official Node.js 14 image as base
FROM node:14

# Set the working directory inside the container
WORKDIR /usr/src/app

# Copy the package.json and package-lock.json files to the working directory
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application code to the working directory
COPY . .

# Expose the port your app runs on
EXPOSE 3000

# Start the application
CMD ["npm", "start"]
