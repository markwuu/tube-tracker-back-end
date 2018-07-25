import * as express from 'express'

const app = express()
const PORT = 3000

app.get('/', (req, res) => res.send('Tube Tracker back-end'))
app.listen(PORT, () => console.log('Listening on port ' + PORT))