FROM node:20-alpine

LABEL maintainer="nazar"

WORKDIR /var/www/html

RUN yarn install; \
	yarn cache clean \

COPY package.json yarn.lock ./

COPY . .

EXPOSE 5173

CMD ["yarn", "dev"]
