const express = require('express')
const app = express()

app.get('/', (req, res) => res.send('Tube Tracker Back-End'))

app.listen(3000, () => console.log('Listening on port 3000'))
