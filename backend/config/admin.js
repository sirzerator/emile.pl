module.exports = ({ env }) => ({
  auth: {
    secret: env('ADMIN_JWT_SECRET', 'a3e0fe72aa833ec972b0c6fdcbd1574f'),
  },
});
