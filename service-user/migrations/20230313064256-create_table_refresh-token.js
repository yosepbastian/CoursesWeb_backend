'use strict';


module.exports = {
 up: async (queryInterface, Sequelize) => {
   await queryInterface.createTable('refresh_token',{
    id: {
      type: Sequelize.INTEGER,
      primaryKey: true,
      autoIncrement:true,
      allowNull : false
    },
    token: {
      type: Sequelize.TEXT,
      allowNull:false,
    },
    users_id: {
      type: Sequelize.INTEGER,
      allowNull: false
    },
    created_at: {
      type: Sequelize.DATE ,
      allowNull: false
    },
    updated_at: {
      type: Sequelize.DATE,
      allowNull: false
    }
  });

  await queryInterface.addConstraint('refresh_token', {
    type: 'foreign key',
    name: 'REFRESH_TOKEN_USER_ID',
    fields: ['users_id'],
    references: {
      table: 'users',
      field: 'id'
    }
  })
  return
   
  },

  down: async  (queryInterface, Sequelize) => {
    return queryInterface.dropTable('refresh_token')
  }
};
