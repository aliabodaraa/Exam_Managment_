FROM node

WORKDIR /app

COPY package.json .

RUN npm install

COPY . .

EXPOSE 4200
EXPOSE 49153

CMD /app/node_modules/.bin/ng serve --host 0.0.0.0 --poll 500

# to run it independently
# docker build -t frontend-image .
# docker run --name frontend-container --rm -p 4200:4200 -p 49153:49153 -v ${PWD}:/app -v /app/node_modules -it frontend-image