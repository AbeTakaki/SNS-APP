import Link from 'next/link'
 
export default function NotFound() {
  return (
    <>
      <div className="flex justify-center">
          <h2 id="not-found" className="text-3xl font-bold m-4">404 Not Found</h2>
      </div>
      <div className="flex justify-center">
          <Link href="/xweet">Return Home</Link>
      </div>
    </>
  )
}