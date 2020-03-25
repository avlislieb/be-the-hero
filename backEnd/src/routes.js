const express = require('express');

const OngController = require('./controllers/OngController');
const IncidentController = require('./controllers/IncidentController');
const ProfileController = require('./controllers/ProfileController');
const SessionController = require('./controllers/SessionController');

const routes = express.Router();


/**
 * TIPOS DE PARAMETROS 
 * Query params: Parâmetros nomeados enviado na rota apos o simbolo de interrogação (filtros, paginação, ) 
 * Route params: Parâmetros indentificados para identificar recursos 
 * Request Body: Corpo da requisição utilizado para criar ou alterar recursos 
 */
routes.post('/session', SessionController.create);

routes.get('/ongs', OngController.index);
routes.post('/ongs', OngController.create);

routes.get('/incidents', IncidentController.index);
routes.post('/incidents', IncidentController.create);
routes.delete('/incidents/:id', IncidentController.delete);

routes.get('/profile', ProfileController.index);

module.exports = routes;