import React, { useEffect, useState } from 'react'
import CustomTable from 'components/table'
import ModalInfo from 'components/modal'

export const DashboardPage = () => {
  const [example, setExample] = useState('')
  const triggerModal = (value) => {
    setExample(value)
  }
  useEffect(() => {
    console.log(`example is:  ${example}`)
  }, [example])
  return (
    <>
      <CustomTable />
      <ModalInfo setData={triggerModal} info={{ name: 'Nghi', age: 29 }} />
    </>
  )
}

// export default Dashboard
