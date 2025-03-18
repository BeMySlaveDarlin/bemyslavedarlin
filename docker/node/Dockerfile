FROM node:20

ARG NODE_JS_APP_PORT
ARG APP_ENV
ARG NODE_MODE
ENV NPM_CONFIG_PREFIX=/var/www/app/node_modules
ENV PATH="$NPM_CONFIG_PREFIX/.bin:$PATH"

WORKDIR /var/www/app

COPY package*.json ./

RUN npm install

COPY . .

EXPOSE $NODE_JS_APP_PORT

CMD ["npm", "run", "build"]
