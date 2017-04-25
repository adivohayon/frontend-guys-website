# Create image based on the official Node 6 image from dockerhub
FROM node:6

# prepare a user which runs everything locally! - required in child images!
RUN useradd --user-group --create-home --shell /bin/false app

ENV APPDIR=/home/app

WORKDIR $APPDIR


# Copy dependency definitions
COPY package.json $APPDIR

# Install dependecies
RUN npm install

# Get all the code needed to run the app
COPY . $APPDIR

# Expose the port the app runs in
EXPOSE 4200

# Serve the app
CMD ["npm", "start"]