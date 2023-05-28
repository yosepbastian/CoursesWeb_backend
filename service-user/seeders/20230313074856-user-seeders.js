'use strict';
const bycrypt = require('bcrypt');


module.exports = {
  up:  async (queryInterface, Sequelize) =>{
   await queryInterface.bulkInsert('users',[
    {
      name: "bastian",
      profession: "Admin micro",
      role: "admin",
      email: "bastianmck@gmail.com",
      password: await bycrypt.hash('joseph50', 10),
      created_at: new Date(),
      updated_at: new Date(),
    },
    {
      name: "yosep",
      profession: "Front End",
      role: "student",
      email: "yosep@gmail.com",
      password: await bycrypt.hash('panjaitan50', 10),
      created_at: new Date(),
      updated_at: new Date(),
    }
  ])
  },

  down: async (queryInterface, Sequelize) => {
   await queryInterface.bulkDelete('users',null, {})
  }
};
