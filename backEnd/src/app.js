const express = require('express');
const cors = require('cors');
const { errors } = require('celebrate');
const routes = require('./routes');
const app = express();
//falando que no corpo da requisição transforma o json em um obj
app.use(cors());
app.use(express.json());
app.use(routes);
app.use(errors());

module.exports = app;
