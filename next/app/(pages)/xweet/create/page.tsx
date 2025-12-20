import Auth from "@/src/components/auth"
import PostForm from "@/src/components/element/postform"

export default function Page(){
  return(
    <>
      <Auth>
        <PostForm />
      </Auth>
    </>
  )
}