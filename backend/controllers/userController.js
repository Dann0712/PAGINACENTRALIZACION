const login = async (req, res) => {
  const { username, password } = req.body;
  
  try {
    // Usar los nombres de columnas correctos
    const [user] = await pool.query(
      'SELECT * FROM usuarios WHERE usuario = ?', 
      [username]
    );
    
    if (!user[0]) {
      return res.status(400).json({ error: 'Usuario no encontrado' });
    }
    
    // Verificar contraseña SHA-256
    const crypto = require('crypto');
    const hashedInput = crypto.createHash('sha256').update(password).digest('hex');
    
    if (hashedInput !== user[0].contraseña) {
      return res.status(400).json({ error: 'Contraseña incorrecta' });
    }
    
    // Verificar estado del usuario
    if (user[0].estado !== 'Activo') {
      return res.status(403).json({ error: 'Usuario inactivo' });
    }
    
    // Mapear id_rol a roles (asumiendo: 1=empleado, 2=supervisor, 3=administrador)
    const roles = {
      1: 'empleado',
      2: 'supervisor',
      3: 'administrador'
    };
    
    const rolNombre = roles[user[0].id_rol] || 'sin_rol';
    
    const token = jwt.sign(
      { id: user[0].id_usuario, rol: rolNombre },
      process.env.JWT_SECRET,
      { expiresIn: '8h' }
    );
    
    res.json({ token, rol: rolNombre });
  } catch (err) {
    console.error(err);
    res.status(500).send('Error del servidor');
  }
};