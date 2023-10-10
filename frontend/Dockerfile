FROM node:14

WORKDIR /app

COPY . .

RUN npm install
RUN npm install vue-router
RUN npm i --save @fortawesome/fontawesome-svg-core
RUN npm i --save @fortawesome/free-regular-svg-icons
RUN npm i --save @fortawesome/vue-fontawesome@latest-3

RUN npm run build

EXPOSE 8080

CMD ["npm","run","serve"]