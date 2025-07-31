adminDb = db.getSiblingDB("admin");

adminDb.createUser(
    {
        user: "dev",
        pwd: "dev",
        roles: [{ role: "readWrite", db: "dev" }],
    }
);

prodDb = db.getSiblingDB("production");

prodDb.createUser(
    {
        user: "prod",
        pwd: "prod",
        roles: [{ role: "readWrite", db: "production" }],
    }
);


devDb = db.getSiblingDB('dev');

devDb.createUser(
    {
        user: "dev",
        pwd: "dev",
        roles: [{ role: "readWrite", db: "dev" }],
    }
);

devDb.createCollection('articles');
devDb.createCollection('pictures');
devDb.createCollection('users');

devDb.articles.createIndex({"slug": 1}, {"unique": true});

devDb.users.createIndex({"nickname": 1}, {"unique": true});
devDb.users.createIndex({"email": 1}, {"unique": true});

devDb.pictures.createIndex({"picture.source": 1}, {"unique": true});

