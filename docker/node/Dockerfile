FROM node:20-alpine

LABEL maintainer="nazar"

# Set working directory
WORKDIR /var/www/html

RUN yarn install; \
	yarn cache clean \

# Copy package files
COPY package.json yarn.lock ./

# Copy the rest of the project files
COPY . .

# Expose Vite default dev port
EXPOSE 5173

# Start Vite development server (can be overridden in docker-compose or CLI)
CMD ["yarn", "dev"]
