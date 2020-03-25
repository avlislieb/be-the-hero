
exports.up = function(knex) {

    return knex.schema.createTable('ongs', function(table){
        table.string('id').primary();
        table.string('nome').notNullable();
        table.string('email').notNullable();
        table.string('whatsapp').notNullable();
        table.string('city').notNullable();
        table.string('uf', 5).notNullable();
    })
};

exports.down = function(knex) {
    return knex.schema.dropTable('ongs');
};
