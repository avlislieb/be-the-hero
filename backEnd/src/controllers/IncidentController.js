const connection = require('../database/connection');

module.exports = {
    async index(request, response){
        const { page = 1} = request.query;

        const [count] = await connection('incidents').count();

        const incidents = await connection('incidents as i')
        .join('ongs as o', 'o.id', '=', 'i.ong_id')
        .limit(5)
        .offset((page - 1) * 5)
        .select(['*', 'i.id as id']);

        response.header('X-Total-Count', count['count(*)']);
        return response.json(incidents);
    },
    async create(request, response){
        const { title, description, value } = request.body;
        const ong_id = request.headers.authorization;

        const [id] = await connection('incidents').insert({
            title, 
            description,
            value,
            ong_id 
        });
        return response.json({ id });
    },
    async delete(request, response){
        const { id } = request.params;
        const ong_id = request.headers.authorization;
        
        const incident = await connection('incidents').where('id', id).select('ong_id').first();

        if(!incident){
            return response.status(401).json({ error: 'Incident not exist.'});
        }
        else if(incident.ong_id !== ong_id){
            return response.status(401).json({ error: 'Operation not permitted.'});
        }

        await connection('incidents').where('id', id).delete();

        return response.status(204).send();
    }
}