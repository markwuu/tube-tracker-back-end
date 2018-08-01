import { getRepository } from 'typeorm'
import { NextFunction, Request, Response } from 'express'
import { User } from '../entity/User'
import * as bcrypt from 'bcrypt'

export class UserController {
  private userRepository = getRepository(User)

  async signup(request: Request, response: Response, next: NextFunction) {
    try {
      const hash = bcrypt.hashSync(request.body.password, 10)
      const user = await this.userRepository.create({
        email: request.body.email,
        password: hash,
      })
      await this.userRepository.save(user)
      return { id: user.id }
    } catch (e) {
      console.log(e.message)
      return { id: 0 }
    }
  }

  async login(request: Request, response: Response, next: NextFunction) {
    try {
      const user = await this.userRepository.findOne({
        email: request.body.email,
      })
      const isEmailMatching = request.body.email === user.email
      const isPasswordMatching = bcrypt.compareSync(
        request.body.password,
        user.password,
      )
      return isEmailMatching && isPasswordMatching
        ? { isUser: true }
        : { isUser: false }
    } catch (e) {
      console.log(e.message)
      return { isUser: false }
    }
  }
}
