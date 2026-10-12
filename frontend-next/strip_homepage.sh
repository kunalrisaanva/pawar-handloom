#!/bin/bash

# We will remove the layout parts from HomePageClient.tsx
# In HomePageClient.tsx, the layout starts at <div style={{ background: "#fff", minHeight: "100vh" }}>
# And ends with </div> </>. But wait, it's easier to just use sed to delete everything from TOP BANNER up to the end of MAIN HEADER.
# Also delete the FOOTER and MOBILE MENU.

perl -0777 -pi -e 's/\{\/\* ══════════ TOP BANNER ══════════ \*\/}.*?<\/header>//s' src/app/HomePageClient.tsx
perl -0777 -pi -e 's/\{\/\* ══════════ FOOTER ══════════ \*\/}.*?<\/footer>//s' src/app/HomePageClient.tsx
perl -0777 -pi -e 's/\{\/\* ══════════ MOBILE MENU ══════════ \*\/}.*?<\/div>\s*<\/div>\s*<\/div>\s*<\/div>//s' src/app/HomePageClient.tsx

