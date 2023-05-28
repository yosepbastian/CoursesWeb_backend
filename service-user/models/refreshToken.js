

module.exports = (sequelize, DataTypes) => {
    const RefreshToken = sequelize.define ('RefreshToken', {
        id: {
            type: DataTypes.INTEGER,
            autoIncrement: true,
            primaryKey: true,
            allowNull: false
        },
        token: {
            type: DataTypes.TEXT,
            allowNull: false
        },
        users_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        createdAt: {
            field: 'created_at',
            type: DataTypes.DATE,
            allowNull: false,      
        },
        updatedAt: {
            field: 'updated_at',
            type: DataTypes.DATE,
            allowNull: false,      
        },
     }, {
        tableName: 'refresh_token',
        timeStamps:true
     }

    
    );
    return RefreshToken;
}