const express = require('express');
const cors = require('cors');
const routes = require('./routes');
const app = express();
//falando que no corpo da requisição transforma o json em um obj
app.use(cors());
app.use(express.json());
app.use(routes);

app.listen(3333);