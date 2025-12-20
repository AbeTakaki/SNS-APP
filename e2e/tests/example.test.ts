import test, { expect } from "@playwright/test";


test('sample test', async ({page}) => {
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet`, { 
  timeout: 60000});
  await expect(page.locator('h1')).toContainText('Xweet');
})