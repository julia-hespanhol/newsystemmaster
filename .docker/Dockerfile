FROM node:14 as frontend_amber

RUN npm install -g http-server

WORKDIR /var/www/html/amber

COPY package*.json ./

COPY node_modules ./node_modules

RUN npm install

COPY . .

EXPOSE 80

RUN npm run build

CMD [ "http-server", "dist" ]

##CMD ["npm", "start"]






