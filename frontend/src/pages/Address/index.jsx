import React, { useEffect, useState } from 'react'
import { useParams } from 'react-router-dom'

export const Address = () => {
  const { articleId } = useParams()
  return <h1>Đây là Address {articleId}</h1>
}
